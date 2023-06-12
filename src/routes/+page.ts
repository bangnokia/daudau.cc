import type { PageLoad } from './$types';
import type { Post } from '../types/post';
import matter from 'gray-matter';

export const load: PageLoad = async ({ fetch, setHeaders }) => {
	// read all post in folder `/posts`, extract created date, slug, and metadata from file
	const files = import.meta.glob('/posts/*.md', { as: 'raw' });
	const posts: Post[] = [];

	for (const path in files) {
		const fileName = path.split('/').pop()!.replace('.md', '');
		const createdAt = fileName.substring(0, 10)
		const slug = fileName.substring(11)

		const rawContent = await files[path]()
		const { data: { title, tags } } = matter(rawContent)

		posts.push({
			slug,
			title,
			createdAt,
			tags: tags ? tags.split(',').map(tag => tag.trim()) : []
		})
	}

	return {
		posts: posts.reverse()
	}
}

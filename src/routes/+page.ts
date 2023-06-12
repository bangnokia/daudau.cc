import type { PageLoad } from './$types';
import type { Post } from '../types/post';
import matter from 'gray-matter';
import { allPosts } from '../libs/utils';

export const load: PageLoad = async ({ fetch, setHeaders }) => {
	const posts = await allPosts()

	return {
		posts
	}
}

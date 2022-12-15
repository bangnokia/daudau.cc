import type { PageLoad } from './$types';
import type { Post } from 'src/types/post';

export const load: PageLoad = async ({ fetch, setHeaders }) => {
	const response = await fetch('https://lab.daudau.cc/api/blog/posts');
	const posts: Post[] = await response.json();

	setHeaders({
		'cache-control': 'max-age=1800, s-maxage=1800, stale-while-revalidate'
	})

	return {
		posts
	}
}

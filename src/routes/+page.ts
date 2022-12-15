import type { PageLoad } from './$types';

export const load: PageLoad = async ({ fetch, setHeaders }) => {
	const response = await fetch('https://lab.daudau.cc/api/blog/posts');
	const posts = await response.json();

	setHeaders({
		'cache-control': 'max-age=1800, s-maxage=1800, stale-while-revalidate'
	})

	return {
		posts
	}
}

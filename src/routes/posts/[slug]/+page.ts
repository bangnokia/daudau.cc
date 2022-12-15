import type { PageLoad } from './$types';
import type { Post } from 'src/types/post';

export const load: PageLoad = async ({ params, fetch, setHeaders }) => {
	const response = await fetch(`https://lab.daudau.cc/api/blog/posts/${params.slug}`);
	const post: Post = await response.json();

	setHeaders({
		'cache-control': 'max-age=1800, s-maxage=1800, stale-while-revalidate'
	})

	return {
		post
	};
}

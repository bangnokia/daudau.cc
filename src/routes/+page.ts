import type { PageLoad } from './$types';
import { allPosts } from '../lib/utils';

export const load: PageLoad = async ({ fetch, setHeaders }) => {
	const posts = await allPosts()

	return {
		posts
	}
}

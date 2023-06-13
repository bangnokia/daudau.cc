import type { PageLoad } from './$types';
import { getPost } from '../../../lib/utils';

export const load: PageLoad = async ({ params }) => {
	const post = await getPost(params.slug);

	return {
		post: post
	};
}

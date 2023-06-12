import matter from 'gray-matter';
import type { PageLoad } from './$types';
import type { Post } from 'src/types/post';
import { getPost } from '../../../libs/utils';

export const load: PageLoad = async ({ params }) => {
	const post = await getPost(params.slug);

	return {
		post: post
	};
}

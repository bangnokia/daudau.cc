import type { Tag } from './tag';

export interface Post {
	title: string;
	slug: string;
	content?: string;
	createdAt: string;
	tags: Tag[];
}

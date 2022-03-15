import type { Tag } from './tag';

export interface Post {
	id: number;
	title: string;
	slug: string;
	content: string;
	created_at: string;
	tags: Tag[];
}

import { marked } from "marked";
import type { Post } from "../types/post";
import matter from 'gray-matter';

export async function allPosts() {
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
      tags: tags ? tags.split(',').map((tag: string) => tag.trim()) : []
    })
  }

  return posts.reverse()
}

export async function getPost(slug: string) {
  const files = import.meta.glob('/posts/*.md', { as: 'raw' });

  for (const path in files) {
    const rest = path.substring(18);

    if (rest === slug + '.md') {
      const rawContent = await files[path]()
      const fileName = path.split('/').pop()!.replace('.md', '');
      const createdAt = fileName.substring(0, 10)
      const { content, data: { title, tags } } = matter(rawContent)

      return {
        slug,
        title,
        createdAt,
        tags: tags ? tags.split(',').map((tag: string) => tag.trim()) : [],
        content
      }
    }
  }
}
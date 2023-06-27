import type { Post } from "../types/post"
import fm from 'front-matter'
import marked from '$lib/marked'

export async function allPosts() {
  const files = import.meta.glob('/posts/*.md', { as: 'raw' });
  const posts: Post[] = [];

  for (const path in files) {
    const fileName = path.split('/').pop()!.replace('.md', '');
    const createdAt = fileName.substring(0, 10)
    const slug = fileName.substring(11)

    const rawContent = await files[path]()
    const { attributes: { title, tags } } = fm(rawContent)

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
      const { body: content, attributes: { title, tags } } = fm(rawContent)

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
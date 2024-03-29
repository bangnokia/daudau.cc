import type { Post } from "$lib/types"
import fm, { type FrontMatterResult } from 'front-matter'

export async function allPosts() {
  const files = import.meta.glob('/posts/*.md', { as: 'raw', eager: true });
  const posts: Post[] = [];

  for (const path in files) {
    const fileName = path.split('/').pop()!.replace('.md', '');
    const createdAt = fileName.substring(0, 10)
    const slug = fileName.substring(11)

    const rawContent = files[path]
    const { attributes: { title, tags } }: FrontMatterResult<{ title: string, tags: Array }> = fm(rawContent)

    posts.push({
      slug,
      title,
      createdAt,
      tags,
    })
  }

  return posts.reverse()
}

export async function getPost(slug: string) {
  const files = import.meta.glob(`/posts/*.md`, { as: 'raw' });

  for (const path in files) {
    const rest = path.substring(18); // remove the '/posts/yyyy-mm-dd-' string from the path

    if (rest === slug + '.md') {
      const rawContent = await files[path]()
      const fileName = path.split('/').pop()!.replace('.md', '');
      const createdAt = fileName.substring(0, 10)
      const { body: content, attributes: { title, tags } }: FrontMatterResult<{ title: string, tags: Array }> = fm(rawContent)

      return {
        slug,
        title,
        createdAt,
        tags,
        content
      }
    }
  }
}
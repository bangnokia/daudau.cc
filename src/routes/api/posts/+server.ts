import { json } from "@sveltejs/kit";
import { allPosts } from "$lib/utils";

export async function GET() {
  const posts = await allPosts()

  return json(posts)
}
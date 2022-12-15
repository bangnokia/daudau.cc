export async function load({ params, fetch }) {
	const response = await fetch(`https://lab.daudau.cc/api/blog/posts/${params.slug}`);

	throw new Error("@migration task: Migrate this return statement (https://github.com/sveltejs/kit/discussions/5774#discussioncomment-3292693)");
	return {
		cache: 60 * 60 * 5,
		props: {
			post: await response.json()
		}
	};
}

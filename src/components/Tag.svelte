<script lang="ts">
	export let name: string;

	let data: HTMLAnchorElement;
</script>

<a
	href="/#{data?.innerText}"
	bind:this={data}
	class="bg-gray-50 rounded px-2 py-0.5 cursor-pointer hover:bg-gray-100"
	{...$$restProps}
>
	<slot />
</a>

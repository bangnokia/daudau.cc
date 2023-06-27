<script lang="ts">
	let data: HTMLAnchorElement;
</script>

<a
	href="/?tag={data?.innerText}"
	bind:this={data}
	class="text-neutral-500 rounded px-2 py-0.5 cursor-pointer hover:bg-gray-100 hover:decoration-none"
	on:click
	{...$$restProps}
>
	<slot />
</a>

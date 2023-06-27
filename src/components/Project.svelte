<script lang="ts">
	export let name: string;
	export let description: string;
	export let website: string | undefined = undefined;
	export let githubUrl: string;
	export let logo: string | undefined = undefined;
</script>

<div class="p-5 bg-neutral-800 hover:bg-neutral-700 transition rounded-lg">
	<div class="flex w-full items-center gap-5">
		{#if logo}
			<div>
				<img src={logo} alt="logo" class="w-20 h-20" loading="lazy" />
			</div>
		{/if}
		<div class="grow">
			<div class="flex items-center justify-between">
				<div class="flex items-center">
					<a class="text-xl font-medium" href={website || githubUrl} target="_blank">{name}</a>
				</div>
				<div class="flex items-center gap-3">
					{#if website}
						<a href={website} target="_blank">
							<svg
								xmlns="http://www.w3.org/2000/svg"
								class="h-6 w-6 text-gray-500"
								viewBox="0 0 20 20"
								fill="currentColor"
							>
								<title>{name}'s website</title>
								<path
									d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
								/>
							</svg>
						</a>
					{/if}
					<a href={githubUrl} target="_blank">
						<svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<title>{name} on Github</title>
							<path
								d="M0 12.305c0 5.435 3.438 10.047 8.207 11.674.6.113.82-.267.82-.593 0-.292-.011-1.066-.017-2.093-3.339.744-4.043-1.65-4.043-1.65-.545-1.42-1.332-1.798-1.332-1.798-1.09-.764.083-.749.083-.749 1.203.087 1.837 1.268 1.837 1.268 1.071 1.88 2.809 1.338 3.493 1.022.109-.795.42-1.337.762-1.645-2.665-.31-5.466-1.365-5.466-6.08 0-1.343.467-2.442 1.235-3.302-.123-.311-.535-1.562.117-3.256 0 0 1.008-.33 3.3 1.261.958-.273 1.984-.409 3.005-.414 1.019.005 2.046.141 3.004.414 2.29-1.592 3.297-1.261 3.297-1.261.654 1.694.242 2.945.119 3.256.77.86 1.234 1.959 1.234 3.302 0 4.726-2.806 5.767-5.48 6.071.431.38.815 1.13.815 2.279 0 1.645-.015 2.971-.015 3.375 0 .329.216.712.825.591 4.765-1.63 8.2-6.239 8.2-11.672C24 5.508 18.627 0 12 0S0 5.508 0 12.305z"
								fill="#565454"
								fill-rule="evenodd"
							/></svg
						>
					</a>
				</div>
			</div>
			<p class="mt-3">{description}</p>
		</div>
	</div>
</div>

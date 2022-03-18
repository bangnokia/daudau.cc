<script lang="ts">
	import Project from '../components/project.svelte';

	interface ProjectType {
		name: string;
		description: string;
		website?: string;
		githubUrl: string;
		logo?: string;
	}

	let projects: ProjectType[] = [
		{
			name: 'Tinker 2',
			website: 'https://tinker2.app',
			githubUrl: 'https://github.com/bangnokia/tinker2',
			description: 'Laravel and PHP Tinker desktop app',
			logo: '/tinker2.png'
		},
		{
			name: 'Blade Mail',
			website: 'https://blademail.app',
			githubUrl: 'https://github.com/bangnokia/blademail',
			description: 'Desktop app for testing email locally',
			logo: '/blademail.png'
		},
		{
			name: 'Laravel serve livereload',
			githubUrl: 'https://github.com/bangnokia/laravel-serve-livereload',
			description: 'Support live reloading for built-in `artisan serve` command'
		},
		{
			name: 'Pekyll',
			githubUrl: 'https://github.com/bangnokia/pekyll',
			description: 'Markdown static blog generator written in PHP with the powerful of Laravel blade template engine.'
		},
		{
			name: 'CDN Image component',
			githubUrl: 'https://github.com/bangnokia/pekyll',
			description: 'A Laravel blade component for integrating CDN services (statically, cloudimage).'
		}
	];
</script>

<svelte:head>
	<title>Open source projects | Blog of Nguyen</title>
	<meta name="description" content="Soem of my funny open source projects" />
</svelte:head>

<h1 class="text-3xl text-cyan-500">My open source projects</h1>
<p class="text-sm mt-5">Some stupid stuff wrote on my freetime.</p>
<div class="grid mt-10 gap-8 grid-cols-1">
	{#each projects as project}
		<Project {...project} />
	{/each}
</div>

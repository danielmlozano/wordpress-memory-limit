<?php
$mem_limit = get_option('wp_mem_limit');
?>
<div class="wrap">
	<div class="max-w-7xl py-10 sm:px-6 lg:px-8">
		<div class="md:grid md:grid-cols-3 md:gap-6">
			<div class="md:col-span-1">
				<div class="px-4 sm:px-0">
					<h1 class="text-lg font-medium text-gray-900">Change memory limit</h1>
					<p class="mt-1 text-sm text-gray-600">
					The default WordPress memory limit is sometimes not enough, especially if you have a lot of plugins installed. 
					this plugin allows you to increase the memory limit without editing any WordPress files.
					</p>
				</div>
			</div>

			<div class="mt-5 md:mt-0 md:col-span-2">
				<div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
					<form method="post" action="options-general.php?page=<?php echo $this->getSlug(); ?>">
						<input type="hidden" name="process" value="<?php echo $this->getSlug() ?>">
						<br>
						<p><b>Your WordPress memory limit is currently set at:</b> 
						<input type="number" name="mem_limit" required  min="32" value="<?php echo $mem_limit; ?>" class="-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"> MB 
						&nbsp;
						<button class="px-3 py-2 text-white bg-blue-500 rounded-md focus:bg-blue-600 focus:outline-none" type="submit">Change memory limit</button>
						<p class="text-red-700 mt-4">
							<span class="font-bold">Warning!</span> Increasing your memory limit could lead to server performance degradation or even penalties imposed by your hosting provider.
						</p>
						<br>		
						<p class="font-italic text-gray-500">Your current memory usage is approximately <?php echo $this->memory_usage ?>MB.</p>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
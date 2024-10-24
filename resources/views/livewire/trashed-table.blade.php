<div class="bg-gray-900">
    <div class="mx-auto max-w-7xl">
        <div class="bg-gray-900 py-10">
            <x-table
                :addUser="$addUser"
                :columns="$columns"
                :rows="$rows"
                :actions="$actions"
                :pagination="$pagination"
                :currentPage="$currentPage"
                :modal="$modal"
            />
        </div>
    </div>
</div>

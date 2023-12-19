<template>
<div class="bg-gray-50 dark:bg-gray-700 dark:text-white">
    <p class="p-2 text-xl">User's calculation tracker</p>
</div>
<div class="max-h-96 relative overflow-x-auto overflow-y-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    User's name
                </th>
                <th scope="col" class="px-6 py-3">
                    Expresion
                </th>
                <th scope="col" class="px-6 py-3">
                    Result
                </th>
                <th scope="col" class="px-6 py-3">
                    Created at
                </th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="(calculation, i) in user?.calculations"
                :key="i"
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ user.name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ calculation.expression }}
                    </td>
                    <td class="px-6 py-4">
                        {{ calculation.result }}
                    </td>
                    <td class="px-6 py-4">
                        {{ calculation.created_at }}
                    </td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
export default {
    name: 'Tracker',
    props: {
        user: {
            type: Object,
            required: true,
        }
    },
}
</script>

<template>
    <div class="flex w-1/2 space-x-10">
        <div class="w-full flex mx-auto flex-col rounded-xl bg-gray-100 shadow-xl text-gray-800 relative overflow-hidden" style="max-width:300px">
            <input type="text" v-model="displayValue"  @input="handleInput" class="w-full bg-gradient-to-b from-gray-800 to-gray-700 flex items-end text-right py-5 px-6 text-6xl text-white font-thin text-xl">
            <div class="w-full bg-gradient-to-b from-indigo-400 to-indigo-500">
                <div
                    v-for="(values, key) in buttons"
                    :key="key"
                    class="flex w-full">
                    <div
                        v-for="button in values"
                        :key="button"
                        class="w-1/4 border-r border-b border-indigo-400">
                            <button
                                @click="handleButtonClick(button)"
                                class="w-full h-16 outline-none focus:outline-none hover:bg-indigo-700 hover:bg-opacity-20 text-white text-opacity-50 text-xl font-light">
                                {{ button }}
                            </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
        v-if="loaded"
        class="flex w-1/2 space-x-10">
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
    </div>
</template>
<script>
import axios from 'axios';
import ApiClient from '../Services/ApiClient';
import { removeAuthToken } from '../helpers/authHelper';

export default {
    name: 'Calculator',
    data() {
        return {
            loaded: false,
            displayValue: '',
            buttons: [['7', '8', '9', '/'], ['4', '5', '6', '*'], ['1', '2', '3', '-'], ['0', '.', '=', '+'], ['C']],
            user: null,
        }
    },
    async mounted() {
        try {
            await this.getUsersData();
        } catch (e) {

        } finally {
            this.loaded = true;
        }
    },
    methods: {
        async getUsersData() {
            const { data, status } = await ApiClient.getUsersData()
            if (status === 200) {
                this.user = data.data;
            }
        },
        handleInput() {
            this.displayValue = this.displayValue.replace(/[^0-9+\-*/().C.]/g, '');
        },
        handleButtonClick(button) {
            switch (button) {
                case '=':
                    this.calculateResult();
                    break;
                case 'C':
                    this.clearDisplay();
                    break;
                default:
                    this.updateDisplay(button);
                    break;
            }
        },
        updateDisplay(value) {
            this.displayValue += value;
        },
        clearDisplay() {
            this.displayValue = '';
        },
        async calculateResult() {
            try {
                const { data, status } = await ApiClient.PostCalculation(this.displayValue)
                console.log(status, 'sss')
                if (status === 200) {
                    this.displayValue = data.data;
                }
            } catch (error) {
                if (error.response?.status === 401) {
                    removeAuthToken();
                    this.$router.push('/login')
                }
                this.displayValue = 'N/A';
            }
        },
    },
}
</script>

<style scoped>
.calculator {
  width: 300px;
  margin: 50px auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/*.display {
  font-size: 24px;
  margin-bottom: 10px;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 3px;
  background-color: #f9f9f9;
}

.buttons {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 10px;
}

button {
  font-size: 18px;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 3px;
  background-color: #fff;
  cursor: pointer;
} */
</style>

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
    <div class="flex w-1/2 space-x-10">

    </div>
</template>
<script>
import axios from 'axios';
import ApiClient from '../Services/ApiClient';

export default {
    name: 'Calculator',
    data() {
        return {
            displayValue: '',
            buttons: [['7', '8', '9', '/'], ['4', '5', '6', '*'], ['1', '2', '3', '-'], ['0', '.', '=', '+'], ['C']],
        }
    },
    async mounted() {
        try {
            await getUsersData();
        } catch (e) {

        }
    },
    methods: {
        async getUsersData() {
            const { data, status } = await axios.get('/api/user', this.displayValue)
            console.log(data);
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
                if (status === 200) {
                    console.log(data.data);
                    this.displayValue = data.data;
                }
            } catch (error) {
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

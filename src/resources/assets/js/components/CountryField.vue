<template>

      <div class="form-row">
        <label>
          <span>Country</span>
            <select v-model="form.country" name="country" class="form-control">
                <option v-for="option in options" v-bind:value="poption.code">{{ option.name }}</option>
            </select>
          <div class="text-danger font-italic error-country">{{ countryerror }}</div>
        </label>
      </div>
</template>

<script type="text/javascript">
    export default {
        mounted() {
        },

        data(){
            return {
                form: {
                    country: 'IE'
                },
                countryerror: ''
            }
        },

        props: {
            remainingnum: {
                type: Number,
                default: 5
            },
            totalnum: {
                type: Number,
                default: -1
            },
            options: Array,
            productcode: String
        },

        methods: {
            getCart(){
                window.axios.get('/api/shop/cart').then(response => {
                    this.cart = response.data;
                });
            },

            addToCart(){
                if (this.form.quantity > this.remainingnum) {
                    this.quantityerror = 'We only have ' + this.remainingnum + ' remaining';
                } else {
                    window.axios.post('/api/shop/cart/items', this.form).then(response => {
                        this.cart = response.data;
                        serverBus.$emit('cart_updated', this.cart);
                    });
                }
            },
        }
    }
</script>

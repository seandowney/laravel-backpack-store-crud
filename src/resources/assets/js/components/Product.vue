<template>

    <div>
        <p v-if="remainingnum !== 0 && totalnum > 1" class="post-meta">{{ remainingnum }} remaining of {{ totalnum }}</p>
        <div v-if="remainingnum > 1" class="form-row">
            <label>
                <span>Quantity</span>
                <input type="number" v-model="form.quantity" name="quantity" id="quantity" size="100" value="1"  :max="remainingnum" class="form-control">
                <div class="text-danger font-italic error-quantity">{{ quantityerror }}</div>
            </label>
        </div>
        <div class="form-row">
            <label><span>Choose your option below</span>
                <select v-model="form.sku" class="form-control">
                    <option v-for="option in options" v-bind:value="productcode + '-' + option.code">{{ option.title }} - {{ option.price }}</option>
                </select>
            </label>
        </div>
        <button class="btn btn-success dropdown-toggle" @click="addToCart()">Add to Cart</button>
    </div>
</template>

<script type="text/javascript">
    import { serverBus } from '../event-bus.js'
    export default {
        mounted() {
            this.getCart();
        },

        data(){
            return {
                cart: {},
                form: {
                    quantity: 1
                },
                quantityerror: ''
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

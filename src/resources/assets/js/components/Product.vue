<template>

    <div>
        <div v-if="remaining > 0" class="form-row">
            <div class="form-row">
                <label>
                    <span>Choose the size</span>
                    <select v-model="form.sku" name="sku" id="sku" class="form-control">
                        <option v-for="option in options" v-bind:value="productcode + '-' + option.code" v-bind:key="option.code">{{ option.title }} - {{ currency }}{{ option.price }}</option>
                    </select>
                </label>
            </div>
            <div class="form-row">
                <div v-if="remaining > 1">
                    <label>
                        <span>Quantity</span>
                        <select v-model="form.quantity" name="quantity" id="quantity" class="form-control">
                            <option v-for="option in quantities" v-bind:value="option" v-bind:key="option">{{ option }}</option>
                        </select>
                        <div class="text-danger font-italic error-quantity">{{ quantityerror }}</div>
                    </label>
                </div>
                    <p v-if="remaining !== 0" class="post-meta">{{ remaining }} remaining <span v-if="totalnum > 1">of {{ totalnum }}</span></p>
            </div>
            <button class="btn btn-success dropdown-toggle" @click="addToCart()">Add to Basket</button>
            <transition name="fade">
                <div v-if="showsuccess" class="text-success font-italic success-add pull-right">Your item has been added</div>
            </transition>
        </div>
        <div v-else class="form-row">
            <p>There are no more items available.</p>
            <a href="/shop/cart" class="btn btn-success">Visit the Basket</a>
        </div>
        <div v-if="cart.count"><a href="/shop/cart" class="btn btn-success">Visit the Basket</a></div>
    </div>
</template>

<script type="text/javascript">
    import { serverBus } from '../event-bus.js'
    export default {
        mounted() {
            this.getCart();
            this.remaining = this.remainingnum;
            for (var i = 1; i <= this.remaining; i++) {
                this.quantities.push(i);
            }
            this.form.sku = this.productcode + '-' + this.options[0].code;
        },

        data(){
            return {
                cart: {},
                quantities: [],
                form: {
                    sku: '',
                    quantity: 1
                },
                quantityerror: '',
                remaining: 0,
                showsuccess: false
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
            productcode: String,
            currency: String
        },

        computed: {
            // a computed getter
            formQuantity: function () {
            // `this` points to the vm instance
                return parseInt(this.form.quantity, 10);
            }
        },

        methods: {
            getCart(){
                window.axios.get('/api/shop/cart').then(response => {
                    this.cart = response.data;
                });
            },

            addToCart(){
                if (this.formQuantity > this.remaining) {
                    this.quantityerror = 'We only have ' + this.remaining + ' remaining';
                } else {
                    window.axios.post('/api/shop/cart/items', this.form).then(response => {
                        this.cart = response.data;
                        this.remaining -= this.formQuantity;
                        this.showsuccess = true;
                        setTimeout(function() {
                            this.showsuccess = false;
                        }.bind(this), 2000);
                        serverBus.$emit('cart_updated', this.cart);
                    });
                }
            },
        }
    }
</script>
<style type="text/css">
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>

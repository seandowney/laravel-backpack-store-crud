<template>
    <div>
        <div v-if="cart.count == 0">
        <p>
            You have no items in your basket.

            <a class="btn btn-success float-right" href="/shop">Continue Shopping</a>
        </p>
        </div>
        <div v-else>
            <p>
            <a class="btn btn-success float-right" href="/shop">Continue Shopping</a>
            </p>
            <table class="table table-striped">
                <thead>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Per Item</th>
                    <th></th>
                </thead>
                <tbody>
                        <tr v-for="item in cart.items" :key="'product-' + item.id">
                            <td>{{item.product.title}} {{item.option.title}}</td>
                            <td>{{item.num}}</td>
                            <td>{{item.option.price}}</td>
                            <td>
                                <a class="btn btn-danger" @click="removeFromCart(item)">Remove</a>
                            </td>
                        </tr>
                </tbody>
            </table>
            <p>
                You have {{cart.count}} items in your basket to the total amount of {{cart.total}}.
            </p>
            <p>
                Delivery is <b>free</b> inside Ireland.
            </p>
            <p>
                <a class="btn btn-success float-right" href="/shop/checkout">Proceed to checkout</a>
                <a @click="clearCart" href="#">Clear basket</a>
            </p>
        </div>
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
                cart: {
                    count: 0
                },
            }
        },

        methods: {
            getCart(){
                window.axios.get('/api/shop/cart').then(response => {
                    this.cart = response.data;
                });
            },

            removeFromCart(item){
                window.axios.delete('/api/shop/cart/items/' + item.id).then(response => {
                    this.cart = response.data;
                    serverBus.$emit('cart_updated', this.cart);
                });
            },

            clearCart(){
                window.axios.delete('/api/shop/cart').then(response => {
                    this.cart = response.data;
                    serverBus.$emit('cart_updated', this.cart);
                });
            }
        }
    }
</script>
<template>
    <a href="/shop/cart" class="header-cart pull-right"><i class="icon-basket"></i> {{cart.count}}</a>
</template>

<script type="text/javascript">
    import { serverBus } from '../event-bus.js'
    export default {
        mounted() {
            this.getCart();
        },

        created() {
            let self = this;
            serverBus.$on('cart_updated', function(data) {
                self.cart = data;
            })
        },

        data(){
            return {
                cart: {},
            }
        },

        methods: {
            getCart(){
                window.axios.get('/api/shop/cart').then(response => {
                    this.cart = response.data;
                });
            }
        }
    }
</script>
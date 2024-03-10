<template>
    <div :class="style" role="alert">
        {{ title }}
        <hr>
        <p>{{ transactionDetails.message }}</p>
        <ul v-if="transactionDetails.errors">
            <li v-for="e, key in transactionDetails.errors" :key="key">
                {{ e[0] }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props:['alertType', 'transactionDetails', 'title'],
        computed:{
            style(){
                return 'alert alert-'+this.alertType;
            }
        }
    }
</script>

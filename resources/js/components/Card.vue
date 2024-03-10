<template>
    <div class="card mb-3">
        <div class="card-header">{{ title }}</div>
        <div class="card-body">
            <slot name="body-content"></slot>
        </div>
        <div class="card-footer">
            <slot name="footer-content"></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: ['title']
}
</script>

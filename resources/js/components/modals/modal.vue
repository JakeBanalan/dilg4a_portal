<template>
    <div v-if="showModal" class="modal-container">
        <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showModal: false,
        };
    },
    methods: {
        openModal() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
    },
};
</script>

<style scoped>
.modal-container {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    position: relative;
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
}
</style>

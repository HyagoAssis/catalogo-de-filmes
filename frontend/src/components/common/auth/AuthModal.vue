<template>
  <Modal v-model="showModal">
    <Login
      v-if="actualAction === 'login'"
      @change-action="actualAction = $event"
      @close="$emit('close')"
    />
    <Register v-if="actualAction === 'register'" @change-action="actualAction = $event" />
  </Modal>
</template>

<script>
import Modal from '@/components/common/Modal.vue';
import Login from '@/components/common/auth/Login.vue';
import Register from '@/components/common/auth/Register.vue';

export default {
  name: 'AuthModal',
  components: { Register, Modal, Login },

  props: {
    action: {
      type: String,
      default: 'login',
    },
  },

  data() {
    return {
      showModal: true,
      authActions: ['login', 'register', 'forgot_password'],
      actualAction: null,
    };
  },

  created() {
    this.actualAction = this.action;
  },
};
</script>

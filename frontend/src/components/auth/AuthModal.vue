<template>
  <Modal v-model="showModal">
    <Login
      v-if="actualAction === 'login'"
      @change-action="actualAction = $event"
      @close="$emit('close')"
    />
    <Register
      v-if="actualAction === 'register'"
      @change-action="actualAction = $event"
      @close="$emit('close')"
    />
    <Logout v-if="actualAction === 'logout'" @close="$emit('close')" />
  </Modal>
</template>

<script>
import Modal from '@/components/common/Modal.vue';
import Login from './Login.vue';
import Register from './Register.vue';
import Logout from '@/components/auth/Logout.vue';

export default {
  name: 'AuthModal',
  components: { Register, Modal, Login, Logout },

  props: {
    action: {
      type: String,
      default: 'login',
    },
  },

  data() {
    return {
      showModal: true,
      authActions: ['login', 'register', 'logout'],
      actualAction: null,
    };
  },

  watch: {
    action: {
      immediate: true,
      handler() {
        this.actualAction = this.action;
      },
    },
  },
};
</script>

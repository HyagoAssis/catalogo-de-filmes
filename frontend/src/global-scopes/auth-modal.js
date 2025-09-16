import { reactive } from 'vue';

export const authModalStore = reactive({
  show: false,
  action: null,

  open(action) {
    this.show = true;
    this.action = action;
  },

  close() {
    this.show = false;
    this.action = null;
  },
});

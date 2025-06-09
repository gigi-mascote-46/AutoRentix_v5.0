<template>
  <div class="flex w-full">
    <aside class="w-1/4 border-r">
      <ul>
        <li v-for="c in contacts" :key="c.id"
            @click="selectContact(c)"
            :class="{'bg-blue-200': selected && selected.id===c.id}"
            class="p-2 cursor-pointer">
          {{ c.name }}
        </li>
      </ul>
    </aside>
    <section class="flex flex-col w-3/4">
      <div ref="scroll" class="flex-grow p-4 overflow-auto">
        <div v-for="msg in messages" :key="msg.id"
             :class="msg.sender_id===user.id ? 'text-right' : 'text-left'">
          <div class="inline-block p-2 mb-2 rounded"
               :class="msg.sender_id===user.id ? 'bg-green-300' : 'bg-gray-200'">
            {{ msg.message }}
            <div class="text-xs text-gray-600">{{ msg.created_at }}</div>
          </div>
        </div>
      </div>
      <form @submit.prevent="send" class="flex p-4 border-t">
        <input v-model="newMsg" placeholder="Escreve..." class="flex-grow p-2 border rounded"/>
        <button class="px-4 py-2 ml-2 text-white bg-blue-500 rounded">Enviar</button>
      </form>
    </section>
  </div>
</template>

<script>
import Echo from 'laravel-echo';
export default {
  props: ['contacts','user'],
  data() { return {
    selected: null,
    messages: [],
    newMsg: ''
  }},
  methods: {
    selectContact(c) {
      this.selected = c;
      this.fetch(c.id);
    },
    fetch(id) {
      fetch(`/messages/${id}`)
        .then(r=>r.json())
        .then(data=>{ this.messages=data; this.scroll() });
    },
    send() {
      if(!this.newMsg.trim()) return;
      fetch('/messages', {
        method:'POST',
        headers:{
          'Content-Type':'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
          receiver_id: this.selected.id,
          message: this.newMsg
        })
      }).then(()=>{
        this.newMsg='';
      });
    },
    scroll() {
      this.$nextTick(()=>{
        const el = this.$refs.scroll;
        el.scrollTop = el.scrollHeight;
      });
    },
    listen() {
      window.Echo.private(`chat.${this.user.id}`)
        .listen('MessageSent', e => {
          const m = e.message;
          if(this.selected && (m.sender_id===this.selected.id||m.receiver_id===this.selected.id)){
            this.messages.push(m);
            this.scroll();
          }
        });
    }
  },
  mounted() {
    this.listen();
  }
}
</script>

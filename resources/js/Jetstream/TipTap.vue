<template>
  <div class="editor border border-gray-300 rounded-md">
    <editor-menu-bar :editor="editor" v-slot="{ commands, isActive }">
      <div class="menubar border-b p-1 flex">

        <button
            class="text-md leading-none p-3 hover:bg-gray-100 rounded mr-2"
            :class="{ 'bg-gray-200': isActive.heading({ level: 3 }) }"
            @click.prevent="commands.heading({ level: 3 })"
            >
            Heading
        </button>

        <button
          class="p-3 hover:bg-gray-100 rounded"
          :class="{ 'bg-gray-200': isActive.bold() }"
          @click.prevent="commands.bold">
          <svg class="w-4 h-4" viewBox="0 0 24 24" id="icon--bold"><path d="M17.194 10.962A6.271 6.271 0 0012.844.248H4.3a1.25 1.25 0 000 2.5h1.013a.25.25 0 01.25.25V21a.25.25 0 01-.25.25H4.3a1.25 1.25 0 100 2.5h9.963a6.742 6.742 0 002.93-12.786zm-4.35-8.214a3.762 3.762 0 010 7.523H8.313a.25.25 0 01-.25-.25V3a.25.25 0 01.25-.25zm1.42 18.5H8.313a.25.25 0 01-.25-.25v-7.977a.25.25 0 01.25-.25h5.951a4.239 4.239 0 010 8.477z"></path></svg>
        </button>

        <button
          class="p-3 hover:bg-gray-100 rounded"
          :class="{ 'bg-gray-200': isActive.italic() }"
          @click.prevent="commands.italic">
            <svg class="w-4 h-4" viewBox="0 0 24 24" id="icon--italic"><path d="M22.5.248h-7.637a1.25 1.25 0 000 2.5h1.086a.25.25 0 01.211.384L4.78 21.017a.5.5 0 01-.422.231H1.5a1.25 1.25 0 000 2.5h7.637a1.25 1.25 0 000-2.5H8.051a.25.25 0 01-.211-.384L19.22 2.98a.5.5 0 01.422-.232H22.5a1.25 1.25 0 000-2.5z"></path></svg>
        </button>

        <button
          class="p-3 hover:bg-gray-100 rounded"
          :class="{ 'bg-gray-200': isActive.bullet_list() }"
          @click.prevent="commands.bullet_list">
          <svg class="w-4 h-4" viewBox="0 0 24 24" id="icon--ul"><circle cx="2.5" cy="3.998" r="2.5"></circle><path d="M8.5 5H23a1 1 0 000-2H8.5a1 1 0 000 2z"></path><circle cx="2.5" cy="11.998" r="2.5"></circle><path d="M23 11H8.5a1 1 0 000 2H23a1 1 0 000-2z"></path><circle cx="2.5" cy="19.998" r="2.5"></circle><path d="M23 19H8.5a1 1 0 000 2H23a1 1 0 000-2z"></path></svg>
        </button>

        <button
          class="p-3 hover:bg-gray-100 rounded"
          :class="{ 'bg-gray-200': isActive.ordered_list() }"
          @click.prevent="commands.ordered_list">
          <svg class="w-4 h-4" viewBox="0 0 24 24" id="icon--ol"><path d="M7.75 4.5h15a1 1 0 000-2h-15a1 1 0 000 2zm15 6.5h-15a1 1 0 100 2h15a1 1 0 000-2zm0 8.5h-15a1 1 0 000 2h15a1 1 0 000-2zM2.212 17.248a2 2 0 00-1.933 1.484.75.75 0 101.45.386.5.5 0 11.483.63.75.75 0 100 1.5.5.5 0 11-.482.635.75.75 0 10-1.445.4 2 2 0 103.589-1.648.251.251 0 010-.278 2 2 0 00-1.662-3.111zm2.038-6.5a2 2 0 00-4 0 .75.75 0 001.5 0 .5.5 0 011 0 1.031 1.031 0 01-.227.645L.414 14.029A.75.75 0 001 15.248h2.5a.75.75 0 000-1.5h-.419a.249.249 0 01-.195-.406L3.7 12.33a2.544 2.544 0 00.55-1.582zM4 5.248h-.25A.25.25 0 013.5 5V1.623A1.377 1.377 0 002.125.248H1.5a.75.75 0 000 1.5h.25A.25.25 0 012 2v3a.25.25 0 01-.25.25H1.5a.75.75 0 000 1.5H4a.75.75 0 000-1.5z"></path></svg>
        </button>

        <button
          class="p-3 hover:bg-gray-100 rounded"
          :class="{ 'bg-gray-200': isActive.blockquote() }"
          @click.prevent="commands.blockquote"
        >
          <svg class="w-4 h-4" viewBox="0 0 24 24" id="icon--quote"><path d="M18.559 3.932a4.942 4.942 0 100 9.883 4.609 4.609 0 001.115-.141.25.25 0 01.276.368 6.83 6.83 0 01-5.878 3.523 1.25 1.25 0 000 2.5 9.71 9.71 0 009.428-9.95V8.873a4.947 4.947 0 00-4.941-4.941zm-12.323 0a4.942 4.942 0 000 9.883 4.6 4.6 0 001.115-.141.25.25 0 01.277.368 6.83 6.83 0 01-5.878 3.523 1.25 1.25 0 000 2.5 9.711 9.711 0 009.428-9.95V8.873a4.947 4.947 0 00-4.942-4.941z"></path></svg>
        </button>

        <button
          class="ml-auto p-3 hover:bg-gray-100 rounded"
          @click.prevent="commands.undo"
        >
          <svg class="w-4 h-4" viewBox="0 0 24 24" id="icon--undo"><path d="M17.786 3.77a12.542 12.542 0 00-12.965-.865.249.249 0 01-.292-.045L1.937.269A.507.507 0 001.392.16a.5.5 0 00-.308.462v6.7a.5.5 0 00.5.5h6.7a.5.5 0 00.354-.854L6.783 5.115a.253.253 0 01-.068-.228.249.249 0 01.152-.181 10 10 0 019.466 1.1 9.759 9.759 0 01.094 15.809 1.25 1.25 0 001.473 2.016 12.122 12.122 0 005.013-9.961 12.125 12.125 0 00-5.127-9.9z"></path></svg>
        </button>

        <button
          class="p-3 hover:bg-gray-100 rounded"
          @click.prevent="commands.redo"
        >
          <svg class="w-4 h-4" viewBox="0 0 24 24" id="icon--redo"><path d="M22.608.161a.5.5 0 00-.545.108L19.472 2.86a.25.25 0 01-.292.045 12.537 12.537 0 00-12.966.865A12.259 12.259 0 006.1 23.632a1.25 1.25 0 001.476-2.018 9.759 9.759 0 01.091-15.809 10 10 0 019.466-1.1.25.25 0 01.084.409l-1.85 1.85a.5.5 0 00.354.853h6.7a.5.5 0 00.5-.5V.623a.5.5 0 00-.313-.462z"></path></svg>
        </button>

      </div>
    </editor-menu-bar>

    <editor-content :editor="editor" />
  </div>
</template>

<script>
import { Editor, EditorContent, EditorMenuBar } from 'tiptap'
import {
  Blockquote,
  CodeBlock,
  HardBreak,
  Heading,
  HorizontalRule,
  OrderedList,
  BulletList,
  ListItem,
  TodoItem,
  TodoList,
  Bold,
  Code,
  Italic,
  Link,
  Strike,
  Underline,
  History,
} from 'tiptap-extensions'

export default {
  components: {
    EditorContent,
    EditorMenuBar
  },
  props: ['value'],
  data() {
    return {
      editor: new Editor({
        extensions: [
          new Blockquote(),
          new BulletList(),
          new HardBreak(),
          new Heading({ levels: [3] }),
          new ListItem(),
          new OrderedList(),
          new Link(),
          new Bold(),
          new Italic(),
          new History(),
        ],
        onUpdate: ({getHTML}) => {
          const state = getHTML()
          this.$emit('input', state)
        },
        content: this.value,
      }),
    }
  },
  mounted() {
      let editorClasses = ['overflow-y-auto', 'w-full', 'max-w-full', 'h-48','prose','outline-none','p-3','focus:border-indigo-300','focus:ring','focus:ring-indigo-200','focus:ring-opacity-50','rounded-b-md','shadow-sm'];
      this.editor.view.dom.classList.add(...editorClasses);
  },
  beforeDestroy() {
    this.editor.destroy()
  },
}
</script>

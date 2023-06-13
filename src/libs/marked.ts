import { Marked } from "marked"
import { markedHighlight } from 'marked-highlight';
import hljs from 'highlight.js';

const marked = new Marked();

marked.use(
  markedHighlight({
    langPrefix: 'hljs language-',
    highlight(code, lang) {
      const language = hljs.getLanguage(lang) ? lang : 'plaintext';
      return hljs.highlight(code, { language }).value;
    }
  })
);


export default marked;


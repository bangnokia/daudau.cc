import MarkdownIt from "markdown-it"
import Anchor from "markdown-it-anchor"

const marked = MarkdownIt({
  linkify: true
});

marked.use(Anchor, {
  level: 2,
})

export default marked

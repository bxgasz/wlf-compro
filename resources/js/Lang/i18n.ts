import { createI18n } from 'vue-i18n'
import en from './en.json'
import id from './id.json'

const languages = {
   en,
   id
}

const i18n = createI18n({
   legacy: false,
   locale: localStorage.getItem('locale') || 'en',
   fallbackLocale: 'en',
   messages: languages
})

export default i18n
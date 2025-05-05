export const formatDate = (dateString: string, lang: 'id' | 'en' = 'id'): string => {
   const date = new Date(dateString);
   const options: Intl.DateTimeFormatOptions = { day: '2-digit', month: 'long', year: 'numeric' };
 
   return new Intl.DateTimeFormat(lang === 'id' ? 'id-ID' : 'en-GB', options).format(date);
 };
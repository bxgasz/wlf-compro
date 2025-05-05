import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

export const useShare = (title: string, url: string) => {
   const shareUrl = computed(() => encodeURIComponent(url));

   const copyLink = async () => {
      if (navigator.clipboard && window.isSecureContext) {
      try {
         await navigator.clipboard.writeText(url);
         alert('Link copied to clipboard!');
         return;
      } catch (err) {
         console.error('Clipboard API gagal, mencoba metode alternatif...');
      }
      }
   
      const textArea = document.createElement('textarea');
      textArea.value = url;
      document.body.appendChild(textArea);
      textArea.select();
      document.execCommand('copy');
      document.body.removeChild(textArea);
      alert('Link copied to clipboard!');
   };

   const shareOnFacebook = () => {
      window.open(`https://www.facebook.com/sharer/sharer.php?u=${shareUrl.value}`, '_blank');
   };

   const shareOnLinkedIn = () => {
      window.open(`https://www.linkedin.com/shareArticle?mini=true&url=${shareUrl.value}&title=${title}`, '_blank');
   };

   const shareOnX = () => {
      window.open(`https://twitter.com/intent/tweet?text=${title}&url=${shareUrl.value}`, '_blank');
   };

   return { copyLink, shareOnFacebook, shareOnLinkedIn, shareOnX };
};

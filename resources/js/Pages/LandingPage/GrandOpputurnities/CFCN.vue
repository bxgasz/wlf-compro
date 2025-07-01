<script setup>
import ArrowBack from '@/Icons/ArrowBack.vue';
import Footer from '../Components/Footer.vue';
import Navbar from '../Components/Navbar.vue';
import { Link } from '@inertiajs/vue3';
import Accordion from '../Components/Accordion.vue';
import { useI18n } from 'vue-i18n';
import { ref } from 'vue';

const props = defineProps({
   programCategories: Object
})

const { locale } = useI18n()

const tabActive = ref('General Question')

const lists = [
   {
      category: {
         en: 'General Question',
         id: 'Pertanyaan Umum'
      },
      data: [
         {
            category: 'general',
            question: {
               id: 'Bagaimana cara mengajukan pernyataan minat kerjasama dana hibah dan mengirimkan concept note ke WLF?',
               en: 'How can we submit a Statement of Interest and Concept Note to WLF?'
            },
            answer: {
               id: 'Berikut ini langkah-langkah yang harus dilakukan untuk mengajukan kerjasama dana hibah WLF dan mengirimkan concept note ke WLF: <br> 1. Silahkan mengakses halaman website WLF (http://wlf.or.id), kemudian masuk ke menu Peluang Dana Hibah (Grant Opportunities). <br> 2. Pada halaman tersebut, silahkan mengunduh file Informasi Call for Concept Notes dan membacanya dengan seksama informasi yang ada di dalamnya.<br> 3. Lanjutkan dengan mengunduh file Formulir Concept Notes kemudian silahkan melengkapi informasi yang diperlukan dalam formulir tersebut sesuai dengan desain usulan proyek yang ingin diajukan.<br> 4. Kirimkan (submit) Concept Notes anda, silahkan membuka halaman Pengajuan Pernyataan Minat Kerjasama (link halaman ini dapat ditemukan di dalam dokumen Informasi Call for Concept Notes yang telah Anda unduh sebelumnya).',
               en: '1.	Visit WLF’s website at http://wlf.or.id and go to the Grant Opportunities section. <br> 2. Download and carefully read the Call for Concept Notes Information Sheet. <br> 3. Download the Concept Note Form and complete it based on your proposed project design. <br> 4. To submit your application, go to the Submission Page for Statement of Interest (link available in the Information Sheet).'
            }
         },
      ]
   },
   {
      category: {
         en: 'Organizational',
         id: 'Kriteria Organisasi'
      },
      data: [
         {
            category: 'organizational',
            question: {
               id: 'Apakah organisasi berbasis komunitas yang belum memiliki legalitas, atau lembaga yang berbentuk perusahaan (profit) bisa mengakses dana hibah WLF baik secara mandiri maupun sebagai anggota konsorsium?',
               en: 'Can community-based organizations without legal status, or for-profit entities, apply for the grant?'
            },
            answer: {
               id: 'Call for Concept Notes yang sedang dipublikasikan saat ini ditujukan untuk organisasi masyarakat sipil atau organisasi non-profit yang berbadan hukum resmi sebagai yayasan atau perkumpulan serta terdaftar pada Kementerian Hukum dan Hak Asasi Manusia. Hal ini juga berlaku bagi calon mitra yang mengajukannya sebagai konsorsium.',
               en: 'No. This call is open to non-profit Civil Society Organizations that are legally registered as a foundation (yayasan) or association (perkumpulan) with the Ministry of Law and Human Rights. This also applies to organizations applying as a consortium.'
            },
         },
         {
            category: 'organizational',
            question: {
               id: 'Apakah organisasi yang belum memiliki NPWP dan/atau belum melaporkan pajak tahunan bisa mengajukan concept note?',
               en: 'Can organizations without an NPWP (Tax Identification Number) or tax report submit a concept note?'
            },
            answer: {
               id: 'Organisasi yang belum memiliki NPWP (Nomor Pokok Wajib Pajak) maupun belum pernah melaporkan atau memiliki laporan SPT (Surat Pemberitahuan Tahunan) Tahunan Wajib Pajak Badan karena alasan tertentu, dipersilakan untuk mengajukan concept note.',
               en: 'Yes. Organizations without an NPWP or those who haven’t submitted an annual corporate tax report may still apply, as long as there are valid reasons for their current status.'
            }
         },
         {
            category: 'organizational',
            question: {
               id: 'Terkait pengalaman pengelolaan dana, apakah ada batas minimal besaran dana yang pernah dikelola maupun ketentuan khusus terkait sumber pendanaannya?',
               en: 'Is there a minimum previous grant amount or specific funding source required?'
            },
            answer: {
               id: 'WLF mempertimbangkan besaran anggaran yang pernah dikelola untuk melihat kapasitas lembaga dalam mengelola dana, namun tidak ada batas minimal maupun kriteria sumber pendanaan tertentu. Silahkan mencantumkan besaran dana proyek yang pernah dikelola baik oleh organisasi yang bersangkutan secara langsung maupun sebagai anggota konsorsium, beserta sumber pendanaannya dalam kurun waktu yang telah ditentukan.',
               en: 'No minimum amount or specific source is required. However, WLF considers the scale of previous grants managed as an indication of capacity. Applicants should list all relevant past grants (including consortium-based projects) and their sources.'
            }
         },
         {
            category: 'organizational',
            question: {
               id: 'Apakah organisasi yang mengajukan usulan proyek harus mempunyai pengalaman terkait tema proyek tersebut?',
               en: 'Must the organization have experience in the proposed theme?'
            },
            answer: {
               id: 'Organisasi yang mengajukan usulan proyek harus memiliki pengalaman dalam menjalankan proyek sesuai tema yang diajukan tersebut.',
               en: 'Yes. Applicants must demonstrate experience in implementing programs that align with the chosen theme.'
            }
         },
         {
            category: 'organizational',
            question: {
               id: 'Apakah organisasi yang berdomisili di luar NTT bisa mengajukan concept note?',
               en: 'Can organizations based outside of East Nusa Tenggara (NTT) apply?'
            },
            answer: {
               id: 'Organisasi yang berkantor di luar NTT bisa mengajukan concept note sepanjang memenuhi kriteria yang telah ditetapkan.',
               en: 'Yes, as long as all eligibility criteria are met.'
            }
         },
         {
            category: 'organizational',
            question: {
               id: 'Apakah organisasi yang belum pernah diaudit bisa mengajukan concept note?',
               en: 'Can organizations that have never been audited still apply?'
            },
            answer: {
               id: 'Bisa mengajukan. Namun meskipun tidak menjadi syarat mutlak, hasil audit  akan menjadi pertimbangan pada saat proses seleksi.',
               en: 'Yes. An audit report is not mandatory, but it may be taken into consideration during the selection process.'
            }
         },
         {
            category: 'organizational',
            question: {
               id: 'Apakah satu organisasi bisa mengajukan lebih dari satu concept note?',
               en: 'Can one organization submit more than one concept note?'
            },
            answer: {
               id: 'Satu organisasi bisa mengajukan lebih dari satu concept note, akan tetapi apabila memenuhi semua kriteria, hanya akan ada satu concept note yang bisa terpilih.',
               en: 'Yes. However, only one concept note per organization may be selected for funding.'
            }
         },
      ]
   },
   {
      category: {
         en: 'Collaboration',
         id: 'Kolaborasi'
      },
      data: [
         {
            category: 'collaboration',
            question: {
               id: 'Apakah diperbolehkan untuk berkolaborasi dengan organisasi lain dalam pengajuan concept note?',
               en: 'Can we submit a concept note in collaboration with another organization?'
            },
            answer: {
               id: 'Mitra dapat mengajukan concept note dan berkolaborasi dengan organisasi lain dalam skema konsorsium. Apabila concept note diajukan oleh beberapa organisasi atau dalam skema konsorsium, maka nama-nama organisasi pengaju berikut perannya dalam konsorsium (sebagai ‘Lead Organization’, atau sebagai anggota) dapat diisikan pada kolom ‘Nama Organisasi’ pada formulir Concept Note. Apabila usulan proyek telah disetujui, mitra tidak diperbolehkan untuk mengalihkan kerjasama hibah baik sebagian maupun seluruhnya (sub-contracting) kepada organisasi lain.',
               en: 'Yes. You may apply as a consortium. In the Concept Note Form, include all member organizations and specify roles (e.g., Lead Organization, Member). Note: Subcontracting to other organizations is not allowed once a grant is approved.'
            }
         },
         {
            category: 'collaboration',
            question: {
               id: 'Apakah organisasi yang berdomisili di luar NTT perlu/harus bekerjasama dengan organisasi lokal di Nusa Tenggara Timur untuk dapat mengajukan concept note?',
               en: 'Do organizations outside NTT need to collaborate with local organizations in NTT?'
            },
            answer: {
               id: 'Tidak diwajibkan.',
               en: 'No. This is not required.'
            }
         },
         {
            category: 'collaboration',
            question: {
               id: 'Untuk konsorsium, apakah semua anggota konsorsium harus memenuhi kriteria organisasi?',
               en: 'Must all consortium members meet the eligibility criteria?'
            },
            answer: {
               id: 'Setiap anggota konsorsium harus memenuhi kriteria kelembagaan organisasi. Namun demikian, anggota konsorsium dapat saling melengkapi satu sama lain untuk pemenuhan kriteria pengalaman pengelolaan program/proyek di kawasan timur Indonesia maupun kriteria pengelolaan dana hibah.',
               en: 'Yes. Each member must meet the institutional eligibility criteria. However, members may complement each other in terms of programmatic or grant management experience in Eastern Indonesia.'
            }
         },
         {
            category: 'collaboration',
            question: {
               id: 'Apakah ada batasan jumlah anggota konsorsium?',
               en: 'Is there a limit to the number of consortium members?'
            },
            answer: {
               id: 'Tidak ada batasan.',
               en: 'No.'
            }
         },
         {
            category: 'collaboration',
            question: {
               id: 'Apakah ada format khusus untuk pernyataan dan/atau pembagian peran antar anggota konsorsium untuk dilampirkan dalam concept note?',
               en: 'Is a specific format required to describe roles and responsibilities within the consortium?'
            },
            answer: {
               id: 'WLF tidak  menyediakan format terpisah untuk pernyataan dan/atau pembagian peran antar anggota konsorsium, silahkan menambahkan informasi yang diperlukan pada bagian ‘Pengelolaan Proyek’ di dalam Formulir Concept Note WLF untuk menjelaskan hal tersebut. Apabila diperlukan, organisasi dipersilakan melampirkan dokumen pendukung untuk melengkapi penjelasan yang tertera di dalam Concept Note.',
               en: 'No. This can be explained in the Project Management section of the Concept Note Form. Additional supporting documents may be attached if necessary.'
            }
         },
      ]
   },
   {
      category: {
         en: 'Location & Scope',
         id: 'Lokasi & Cakupan'
      },
      data: [
         {
            question: {
               id: 'Apakah ada prioritas atau preferensi lokasi program WLF di Provinsi NTT (kabupaten, kecamatan, desa/kelurahan)?',
               en: 'Does WLF prioritize specific districts or villages within NTT?'
            },
            answer: {
               id: 'WLF tidak memiliki preferensi lokasi kabupaten. Mitra dapat mengajukan usulan program sepanjang berada di wilayah Provinsi NTT.',
               en: 'No. As long as the proposed location is within NTT, all districts are equally considered.'
            }
         },
         {
            question: {
               id: 'Apabila melanjutkan proyek yang pernah dilakukan di satu lokasi di NTT, apakah boleh menambahkan lokasi baru?',
               en: "Can we add a new project location in addition to one we've worked in before?"
            },
            answer: {
               id: 'Diperbolehkan untuk menambahkan lokasi baru selain lokasi proyek yang sebelumnya.',
               en: "Yes. You may include both existing and new locations."
            }
         },
         {
            question: {
               id: 'Apakah ada ketentuan jumlah penerima manfaat dan cakupan program (desa, unit sekolah, jumlah guru, jumlah siswa, jumlah anak usia dini, dll)?',
               en: 'Is there a required number of beneficiaries or geographic coverage?'
            },
            answer: {
               id: 'Tidak ada ketentuan jumlah dan cakupan. Namun mitra perlu mempertimbangkan efektivitas dan efisiensi program yang diajukan, salah satunya dengan melihat cakupan dan penerima manfaat yang dijangkau proyek yang diajukan.',
               en: 'No. However, applicants should consider the efficiency and effectiveness of the proposed coverage and beneficiary reach.'
            }
         },
         {
            question: {
               id: 'Apakah diperbolehkan bekerja di lokasi baru yang belum pernah didampingi oleh organisasi pengaju concept note?',
               en: 'Can we propose a new location where our organization has not worked before?'
            },
            answer: {
               id: 'Organisasi yang mengajukan kerjasama hibah diharuskan sudah atau sedang bekerja di lokasi program yang diusulkan.',
               en: 'No. Applicants must already be working—or have worked—in the proposed location.'
            }
         },
      ]
   },
   {
      category: {
         en: 'Budget',
         id: 'Anggaran'
      },
      data: [
         {
            question: {
               id: 'Apakah concept note harus menyertakan anggaran secara rinci?',
               en: 'Do we need to include a detailed budget in the concept note?'
            },
            answer: {
               id: 'Pada tahap pengajuan concept note, mitra hanya perlu mencantumkan perkiraan total keseluruhan anggaran yang diajukan. Namun demikian, pengaju concept note disarankan sudah memiliki gambaran kasar pengalokasian anggaran tersebut. Apabila masuk pada tahap selanjutnya, mitra akan diminta untuk mengajukan perincian anggaran.',
               en: 'No. Only the total proposed budget is required at this stage. However, having a rough internal allocation plan is recommended. A full budget will be requested in the next stage.'
            }
         },
         {
            question: {
               id: 'Apakah pendanaan bisa melalui skema co-funding dengan organisasi lain selain WLF?',
               en: 'Can co-funding from other organizations be included?'
            },
            answer: {
               id: 'WLF tidak menutup kemungkinan dilakukannya skema co-funding proyek dengan organisasi lain. Pastikan informasi ini tertera secara eksplisit di dalam concept note yang diajukan.',
               en: 'Yes. Co-funding is allowed. Please clearly indicate this in the Concept Note.'
            }
         },
         {
            question: {
               id: 'Terkait anggaran, berapa besaran proporsi biaya yang ditetapkan WLF?',
               en: 'What is the required budget allocation ratio?'
            },
            answer: {
               id: 'WLF mengatur proporsi penggunaan anggaran, minimal 65% untuk belanja program, dan 35% untuk biaya operasional dan biaya tidak langsung.',
               en: 'A minimum of 65% for program activities and a maximum of 35% for operational and indirect costs.'
            }
         },
         {
            question: {
               id: 'Apakah WLF akan mendanai program infrastruktur atau pengadaan barang?',
               en: 'Does WLF fund infrastructure or procurement-only projects?'
            },
            answer: {
               id: 'WLF tidak dapat mendanai usulan program yang ditujukan untuk pembangunan infrastruktur maupun yang hanya bersifat pengadaan barang sebagai kegiatan utama. Pengadaan barang yang merupakan bagian dari strategi program atau akan dipergunakan untuk menunjang pencapaian tujuan utama program masih akan dapat dipertimbangkan.',
               en: 'No. WLF does not fund projects focused solely on infrastructure or procurement. However, procurement may be considered if it supports core program objectives.'
            }
         },
         {
            question: {
               id: 'Apakah WLF memiliki daftar eligible dan non-eligible expenditure items?',
               en: 'Does WLF have a list of eligible and non-eligible expenses?'
            },
            answer: {
               id: 'Ketentuan lebih detil akan disampaikan kepada organisasi yang lolos tahap seleksi awal concept note.',
               en: 'This will be provided to shortlisted applicants during the next stage.'
            }
         },
         {
            question: {
               id: 'Apakah WLF mensyaratkan kontribusi pendanaan dari organisasi mitranya? Berapa besaran proporsinya?',
               en: 'Is cost-sharing required from the applicant?'
            },
            answer: {
               id: 'WLF tidak mensyaratkan adanya kontribusi pendanaan dari organisasi mitra, namun terbuka untuk usulan kontribusi pendanaan dari organisasi mitra.',
               en: 'No. It is not mandatory, but WLF welcomes proposals that include partner contributions.'
            }
         },
         {
            question: {
               id: 'Untuk tema literasi dan numerasi, apakah boleh menggunakan dana hibah WLF untuk pengadaan buku bacaan, alat peraga, atau barang pendukung pembelajaran lainnya?',
               en: 'Can grant funds be used to purchase learning materials (e.g., books, teaching aids)?'
            },
            answer: {
               id: 'Penggunaan dana untuk pengadaan barang yang berkaitan langsung dengan capaian proyek dapat dipertimbangkan selama hal tersebut merupakan bagian dari strategi program serta besaran/proporsinya wajar bila dibandingkan dengan proporsi belanja program yang diajukan. Selain proporsi biaya, WLF juga akan mempertimbangkan cakupan program, desain intervensi, dan mekanisme pemilihan vendor pengadaan yang diajukan sebelum memberikan izin penggunaan dana untuk pengadaan barang.',
               en: 'Yes, if the items directly support project outcomes and are reasonable in proportion to the overall program budget. Final approval will consider program scope, intervention design, and procurement mechanisms.'
            }
         },
         {
            question: {
               id: 'Untuk tema peluang ekonomi lokal, apakah boleh menggunakan dana untuk pengadaan barang atau peralatan pendukung kegiatan ekonomi?',
               en: 'For local economic projects, can funds be used to purchase equipment for economic activities?'
            },
            answer: {
               id: 'Penggunaan dana untuk pengadaan barang yang berkaitan langsung dengan capaian proyek dapat dipertimbangkan selama hal tersebut merupakan bagian dari strategi program serta besaran/proporsinya wajar bila dibandingkan dengan proporsi belanja program yang diajukan. Selain proporsi biaya, WLF juga akan mempertimbangkan cakupan program, desain intervensi, dan mekanisme pemilihan vendor pengadaan yang diajukan sebelum memberikan izin penggunaan dana untuk pengadaan barang.',
               en: 'Yes, with the same considerations as above.'
            }
         },
      ]
   },
   {
      category: {
         en: 'Concept Notes',
         id: 'Substansi Concept Notes'
      },
      data: [
         {
            question: {
               id: 'Apakah satu organisasi boleh mengajukan dua concept note untuk dua tema yang berbeda?',
               en: 'Can one organization submit concept notes for more than one theme?'
            },
            answer: {
               id: 'Satu organisasi dapat mengajukan lebih dari satu concept notes untuk tema yang berbeda. Apabila terpilih, hanya satu concept notes yang bisa mendapatkan persetujuan dana hibah dari WLF pada saat yang bersamaan.',
               en: 'Yes. However, only one concept note may be selected for funding at a time.'
            }
         },
         {
            question: {
               id: 'Apabila mengajukan dua tema, apakah cukup dalam satu concept note atau perlu mengajukan dua concept note yang berbeda?',
               en: 'Should separate concept notes be submitted for different themes?'
            },
            answer: {
               id: 'Jika mengajukan dua tema yang berbeda dan program tidak terkait satu sama lainnya, maka perlu perlu mengajukan dua concept note yang berbeda.',
               en: 'Yes, if the themes are unrelated and the projects are distinct.'
            }
         },
         {
            question: {
               id: 'Terkait Tema/Outcome 2. Apakah harus literasi dan numerasi, atau boleh salah satunya saja?',
               en: 'For Theme/Outcome 2, can we focus on either literacy or numeracy, or must we address both?'
            },
            answer: {
               id: 'Mitra diperbolehkan untuk memilih salah satu dari Literasi atau Numerasi dan atau dua-duanya.',
               en: 'You may focus on literacy, numeracy, or both.'
            }
         },
         {
            question: {
               id: 'Untuk tema literasi dan numerasi, apakah aktor kunci yang disasar hanya aktor-aktor pendidikan formal saja?',
               en: 'For literacy and numeracy themes, must the project focus only on formal education actors?'
            },
            answer: {
               id: 'Organisasi dipersilakan untuk mengajukan proyek yang menargetkan aktor-aktor pendidikan formal maupun non formal sesuai dengan desain proyek masing-masing.',
               en: 'No. You may work with both formal and non-formal education actors as appropriate to your project design.'
            }
         },
         {
            question: {
               id: 'Untuk tema peluang ekonomi lokal, apakah aktor kunci yang disasar hanya individu/keluarga yang memiliki anak berusia 0-9 tahun?',
               en: 'For local economic themes, must the target group only include households with children aged 0–9?'
            },
            answer: {
               id: 'Pada prinsipnya, proyek yang diajukan harus berkontribusi terhadap atau menunjukkan dampak terhadap anak usia 0-9 tahun sebagai penerima manfaat akhir. Sehingga aktor kunci utama untuk tema ini salah satunya adalah orang tua/pengasuh anak usia 0-9 tahun dan tidak tertutup kemungkinan melibatkan aktor-aktor lainnya yang relevan dengan desain proyek.',
               en: 'Projects must demonstrate impact on children aged 0–9. While parents/caregivers are key actors, other relevant groups may also be included depending on your intervention strategy.'
            }
         },
         {
            question: {
               id: 'Untuk kegiatan kunci ‘Mendukung forum dan jaringan pemangku kepentingan’, apakah forum atau jaringan pemangku kepentingan yang disasar hanya yang resmi terdaftar?',
               en: 'For the activity “Support stakeholder forums and networks,” must these be officially registered?'
            },
            answer: {
               id: 'Tidak. Organisasi dipersilakan untuk mengidentifikasi forum maupun jaringan pemangku kepentingan yang dianggap paling relevan dengan konteks proyek yang diusulkan serta memprioritaskan forum/jaringan yang sudah ada/terbentuk pada saat proyek dimulai. WLF tidak menganjurkan organisasi untuk membentuk forum maupun jaringan pemangku kepentingan yang baru.',
               en: 'No. You may engage with existing forums and networks relevant to your project. WLF does not recommend creating new networks unless essential.'
            }
         },
         {
            question: {
               id: 'Apakah setiap proyek yang diusulkan harus dilengkapi dengan studi baseline dan endline?',
               en: 'Are baseline and endline studies required for every project?'
            },
            answer: {
               id: 'Proyek yang diusulkan perlu untuk dilengkapi dengan kegiatan asesmen kondisi awal dan asesmen kondisi akhir sebagai bagian dari rangkaian kegiatan pemantauan proyek. Luasan cakupan dan metode asesmen yang diusulkan akan dibahas dan disepakati dalam tahapan selanjutnya apabila concept notes terpilih.',
               en: 'Yes. Initial and final assessments must be included as part of project monitoring. The scope and method will be discussed with shortlisted applicants.'
            }
         },
         {
            question: {
               id: 'Apakah semua (4) strategi kunci WLF perlu disertakan dalam desain proyek?',
               en: 'Must all four WLF key strategies be included in the project design?'
            },
            answer: {
               id: 'Tidak harus keseluruhan strategi kunci WLF disertakan sebagai strategi proyek. Setiap concept note minimal harus mengakomodasikan dua strategi kunci WLF.',
               en: 'No. Each concept note must include at least two of WLF’s key strategies.'
            }
         },
         {
            question: {
               id: 'Apakah yang dimaksud dengan prinsip panduan promoting universal access dan bagaimana penerapannya?',
               en: 'What does “promoting universal access” mean in this context?'
            },
            answer: {
               id: 'Untuk mengatasi masalah akses kelompok marjinal/disabilitas terhadap layanan pengembangan anak usia dini, pendidikan dan peluang ekonomi lokal, maka proyek yang diajukan mitra harus dapat mengidentifikasi dan merefleksikan kemungkinan dan cara-cara dimana kelompok marjinal/disabilitas mungkin akan terabaikan dalam kaitannya dengan implementasi kegiatan dan dalam rangka mencapai hasil akhir proyek. Proyek perlu untuk mengambil langkah-langkah mengatasinya apabila memungkinkan. Concept note yang diajukan perlu menjelaskan bagaimana mekanisme/strategi yang akan dilakukan untuk memastikan hal-hal tersebut.',
               en: 'Projects should identify and address potential barriers faced by marginalized groups, including persons with disabilities, and outline strategies to improve their access to services and project outcomes.'
            }
         },
         {
            question: {
               id: 'Apakah yang dimaksud dengan prinsip panduan challenging gender norms dan bagaimana penerapannya?',
               en: 'What does “challenging gender norms” mean in this context?'
            },
            answer: {
               en: 'Projects should assess and respond to harmful gender norms that may affect implementation or impact. Where relevant, the project should propose actions to challenge such norms.',
               id: 'Usulan proyek perlu menguraikan bagaimana mekanisme yang akan dilakukan untuk mengidentifikasi dan merefleksikan adanya norma-norma gender yang tidak adil/tidak setara yang ada dan berlaku di masyarakat di lokasi program yang berkaitan dengan implementasi kegiatan untuk mencapai hasil akhir proyek, serta bagaimana upaya aktif akan dilakukan apabila memungkinkan untuk menentang norma tersebut.'
            }
         },
      ]
   }
]
</script>

<template>
   <div class="w-full z-0 font-lato text-[18px] overflow-hidden">
      <Navbar/>

      <div class="w-full text-center relative">
         <div class="image-container">
            <img src="/assets/img/about/bg-section.png" alt="about-us">
         </div>
         <h1 class="text-white text-[2rem] md:text-[72px] w-full md:w-max px-8 leading-[1.1] font-playfair font-bold absolute inset-0 left-1/2 top-[70%] -translate-x-1/2 -translate-y-1/2 capitalize">
            {{ $t('grandopp.title') }}
         </h1>
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="max-w-3xl px-8 text-[#000000] font-medium flex flex-col justify-center gap-10">
            <p class="font-extrabold text-center text-4xl capitalize">{{ $t('cfcn.subtitle') }}</p>
            <p class="">{{ $t('cfcn.description') }}</p>
         </div>
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="w-full flex justify-center">
            <div class="max-w-7xl px-8 w-full">
               <div class="flex gap-5 justify-start my-8 overflow-x-auto [&::-webkit-scrollbar]:w-1 [&::-webkit-scrollbar]:h-0 [&::-webkit-scrollbar-track]:bg-[#5A5A5A] [&::-webkit-scrollbar-thumb]:bg-[#D7261C]">
                  <Link :href="route('sub-program', data.slug)" class="w-[19rem] h-[23rem] sm:w-[24rem] sm:h-[35rem] flex-shrink-0 flex justify-start relative fading group" v-for="(data, i) in programCategories" :key="i">
                     <div class="w-full h-full overflow-hidden rounded-2xl img-our-program">
                        <img :src="data.image" class="object-cover w-full h-full transition duration-500 ease-in-out group-hover:scale-125">
                     </div>
                     <div class="h-full w-full absolute p-8 z-20 flex flex-col justify-between">
                        <div class="flex justify-end w-full">
                           <ArrowBack class="bg-white/30 backdrop-blur-sm border-white border-2 rounded-full p-1 w-6 h-6 sm:w-9 sm:h-9 text-[#D86727] group-hover:text-white group-hover:bg-[#D86727] ease-in-out duration-500 rotate-[135deg] z-20 mb-8" />
                        </div>
                        <div class="">
                           <p class="text-white text-[20px] sm:text-3xl w-full font-bold">{{ data.title[locale] }}</p>
                        </div>
                     </div>
                  </Link>
               </div>
            </div>
         </div>
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="max-w-3xl px-8 text-[#000000] font-medium flex flex-col justify-center gap-5">
            <p class="">{{ $t('cfcn.description.1') }}</p>
            <p class="">{{ $t('cfcn.description.2') }}</p>
            <p class="">{{ $t('cfcn.description.3') }}</p>
            <p class="">{{ $t('cfcn.description.4') }}</p>
         </div>
      </div>

      <div class="w-full flex justify-center mt-20">
         <div class="max-w-5xl px-8">
            <div class="grid grid-cols-1 lg:grid-cols-[30%,70%] gap-5">
               <div class="w-72 h-80">
                  <img src="/assets/img/grandopp/step-1.jpg" alt="grandopp" class="w-full h-full object-cover rounded-[20px]">
               </div>
               <div class="flex flex-col gap-5">
                  <p class="text-xl bg-[#D86727] rounded-full p-1 w-8 h-8 text-center text-white">1</p>
                  <p class="font-bold">{{ $t('cfcn.step1.title') }}</p>
                  <p>{{ $t('cfcn.step1.description') }}</p>
                  <a href=" https://drive.google.com/uc?export=download&id=15k1iE7RaCXdZ_pNNsQm-4ivU0G5XW4Ly" class="bg-[#D86727] hover:bg-[#e47636] ease-in-out duration-500 px-6 py-2 text-white rounded-full font-medium w-fit">{{ $t('cfcn.sendbutton') }}</a>
               </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-[70%,30%] mt-20 gap-5">
               <div class="flex flex-col gap-5 order-2 lg:order-1">
                  <p class="text-xl bg-[#D86727] rounded-full p-1 w-8 h-8 text-center text-white">2</p>
                  <p class="font-bold">{{ $t('cfcn.step2.title') }}</p>
                  <p>{{ $t('cfcn.step2.description') }}
                  </p>
                  <a href="https://drive.google.com/uc?export=download&id=1AA_n2DWQJEF4bpefoGYfVnER65-AQJRf" class="bg-[#D86727] hover:bg-[#e47636] ease-in-out duration-500 px-6 py-2 text-white rounded-full font-medium w-fit">{{ $t('cfcn.sendbutton') }}</a>
               </div>
               <div class="w-72 h-80 order-1 lg:order-2">
                  <img src="/assets/img/grandopp/step-2.jpg" alt="grandopp" class="w-full h-full object-cover rounded-[20px]">
               </div>
            </div>
         </div>
      </div>

      <div class="w-full flex justify-center my-20">
         <div class="max-w-3xl px-8 text-[#000000] font-medium flex flex-col justify-center gap-3">
            <p class="text-justify">{{ $t('cfcn.video') }}</p>
            <div class="w-full object-contain">
               <iframe width="100%" height="400" src="https://www.youtube.com/embed/m1MiimX47vc?si=C9QhbImH9vFNtVh8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
         </div>
      </div>

      <div class="w-full flex justify-center mt-20 mb-20">
         <div class="max-w-5xl px-8 space-y-15">
            <h1 class="font-extrabold text-center text-4xl">{{ $t('cfcn.faq.title') }}</h1>
            <p class="text-center text-justify">{{ $t('cfcn.faq.description') }}</p>

            <div class="grid grid-cols-1 lg:grid-cols-[25%,70%] gap-10">
               <div class="lg:hidden">
                  <p role="button" v-for="(i, index) in lists" @click="tabActive = i.category['en']" class="p-3 text-base" :class="tabActive == i.category['en'] ? 'bg-[#D86727] text-white font-semibold' : 'border border-[#D86727]'">{{ i.category[locale] }}</p>
               </div>
               <div class="hidden lg:flex flex-col">
                  <p role="button" v-for="(i, index) in lists" @click="tabActive = i.category['en']" class="p-3 text-base" :class="tabActive == i.category['en'] ? 'bg-[#D86727] text-white font-semibold' : 'border border-[#D86727]', index == 0 ? 'rounded-tr-[20px]' : index == lists.length - 1 ? 'rounded-br-[20px]' : ''">{{ i.category[locale] }}</p>
               </div>
               <div class="">
                  <template v-for="item in lists">
                     <Accordion :list="item.data" v-if="tabActive == item.category['en']"/>
                  </template>
               </div>
            </div>
         </div>
      </div>

      <Footer/>
   </div>
</template>

<style scoped>
.image-container {
  position: relative;
  width: 100%;
  overflow: hidden;
  height: 20rem;
}

.img-our-program::after {
   border-radius: 1rem;
   content: "";
   position: absolute;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   background: linear-gradient(0deg,rgba(18, 24, 58, 1) 0%, rgba(18, 24, 58, 0.49) 61%, rgba(18, 24, 58, 0) 100%);
}

.image-container::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg,rgba(18, 24, 58, 0.8) 0%, rgba(18, 24, 58, 0.5) 50%, rgba(18, 24, 58, 0.8) 100%);
  pointer-events: none;
}

.image-container img, .image-container video{
   width: 100%;
   height: 100%;
   object-fit: cover;
}
</style>
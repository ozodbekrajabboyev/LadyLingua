@props(['pageNumber', 'title', 'type' => 'preview'])

<div class="w-[210mm] h-[297mm] bg-white shadow-lg relative shrink-0 p-12 text-justify flex flex-col">
    <div class="text-xs text-gray-400 mb-8 flex justify-between">
        <span>{{ $title }}</span>
        <span>{{ $pageNumber }}-sahifa</span>
    </div>
    <div class="space-y-4 text-gray-800 text-sm leading-relaxed font-serif">
        <p>Bolaning ismi Santyago edi. U suruvi bilan eski bir tashlandiq cherkovga yetib kelganida kun botayotgan edi. Cherkovning tomi allaqachon qulab tushgan, uning o'rnida esa ulkan chinor daraxti o'sib chiqqan edi.</p>
        <p>Bola o'sha yerda tunab qolishga qaror qildi. U qo'ylarini vayrona darvozadan ichkariga haydab kirdi va ular tunda chiqib ketmasligi uchun yo'lni bir nechta taxtalar bilan to'sib qo'ydi. Bu yerda bo'rilar yo'q edi, lekin qo'ylar ba'zan darbadar kezib ketishar, ularni topish uchun esa butun kunni sarflashga to'g'ri kelardi.</p>
        <p>Santyago ustidagi yopinchig'ini yerga to'shadi va o'qib tugatgan kitobini yostiq qilib boshiga qo'ydi. U uyquga ketishdan oldin, endi qalinroq kitoblar o'qish kerakligini, chunki ular ham uzoqroqqa yetishini, ham yostiq sifatida qulayroq ekanligini o'yladi.</p>
        <p>U uyg'onganda hali qorong'u edi. U tepaga qaradi va yarim vayrona tomdan yulduzlar charaqlab turganini ko'rdi.</p>
        <p>— Yana ozgina uxlashim kerak edi, — deb o'yladi u. U bir hafta oldin ko'rgan tushini yana ko'rgan edi va bu safar ham tushi eng qiziq joyida uzilib qoldi.</p>
    </div>
    <div class="mt-4 space-y-3 opacity-30">
        <div class="h-2 bg-gray-300 rounded w-full"></div>
        <div class="h-2 bg-gray-300 rounded w-11/12"></div>
        <div class="h-2 bg-gray-300 rounded w-full"></div>
        <div class="h-2 bg-gray-300 rounded w-10/12"></div>
        <div class="h-2 bg-gray-300 rounded w-full"></div>
    </div>
</div>

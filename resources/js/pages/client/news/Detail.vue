<template>
  <section class="w-full pt-20 pb-16 bg-[#660000] text-white">
    <!-- BREADCRUMB -->
    <div class="max-w-7xl mx-auto px-4 flex items-center gap-2 text-white mb-6">
      <a href="/" class="flex items-center">
        <img src="/images/home-btn.png" alt="Home" class="w-6 h-6" />
      </a>

      <span class="text-xl">›</span>

      <a
        href="/news"
        class="uppercase text-sm tracking-wide hover:text-gray-200"
      >
        TIN TỨC
      </a>

      <span class="text-xl">›</span>

      <span class="uppercase text-sm tracking-wide text-gray-300">
        {{ news.category?.name || "TIN TỨC" }}
      </span>
    </div>

    <!-- Border top -->
    <div class="mx-auto w-[1300px] h-[1px] bg-[#DEDEDE80] mb-12"></div>

    <!-- Title -->
    <div class="text-center mb-10 px-40">
      <h1
        class="font-banque font-bold uppercase leading-tight text-[24px] md:text-[36px] tracking-wide"
      >
        {{ news.title }}
      </h1>

      <!-- Small center line -->
      <div class="w-20 h-[3px] bg-[#D4D4D4] mx-auto mt-4"></div>
    </div>

    <!-- Content -->
    <div
      class="max-w-7xl ml-50 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-20 items-start"
    >
      <!-- Left text -->
      <div class="font-mont text-lg text-justify leading-relaxed space-y-6">
        <div v-html="news.excerpt"></div>
      </div>

      <!-- Right image -->
      <div class="w-full">
        <img
          :src="news.thumbnail"
          alt="Thumbnail"
          class="w-[500px] h-auto object-cover rounded"u
        />
      </div>
    </div>

    <!-- <div class="w-full h-[2px] bg-[#E5E5E5] mx-auto mt-6"></div> -->
  </section>

  <section class="w-full">
    <div class="max-w-6xl mx-auto px-4 pt-16 pb-20 font-mont">
      <h2
        class="font-mont font-bold text-[22px] md:text-[24px] text-[#2e2e2e] mb-6"
      >
        1. VÌ SAO “BỎ PHỐ VỀ RỪNG” TRỞ THÀNH XU HƯỚNG CHỦ ĐẠO?
      </h2>

      <p class="text-[#404040] text-[18px] leading-relaxed mb-8">
        Nếu như trước đây, second home thường gắn với biển hoặc các khu nghỉ
        dưỡng lớn, thì hiện nay điểm đến lại dịch chuyển về
        <strong>núi – rừng – cao nguyên – thung lũng</strong>. Có 4 nguyên nhân
        chính:
      </p>

      <ul class="space-y-8 pl-6">
        <li>
          <p class="text-[18px] font-semibold text-[#2e2e2e] mb-1">
            • Áp lực đô thị ngày càng lớn
          </p>
          <p class="text-[#4a4a4a] text-[17px] leading-relaxed pl-3">
            Ô nhiễm không khí, tiếng ồn, kẹt xe, mật độ dân cư cao khiến nhiều
            người tìm kiếm một “không gian tĩnh” để tái tạo năng lượng mỗi cuối
            tuần. Rừng, đồi và thiên nhiên xanh trở thành lựa chọn lý tưởng.
          </p>
        </li>

        <li>
          <p class="text-[18px] font-semibold text-[#2e2e2e] mb-1">
            • Làm việc linh hoạt (Hybrid) phát triển mạnh
          </p>
          <p class="text-[#4a4a4a] text-[17px] leading-relaxed pl-3">
            Nhiều ngành nghề cho phép làm việc từ xa. Một second home ở rừng
            giúp chủ nhân có thể cân bằng cuộc sống – công việc theo cách thoải
            mái hơn.
          </p>
        </li>

        <li>
          <p class="text-[18px] font-semibold text-[#2e2e2e] mb-1">
            • Xu hướng sống xanh – chữa lành (healing) lên ngôi
          </p>
          <p class="text-[#4a4a4a] text-[17px] leading-relaxed pl-3">
            Sau giai đoạn 2020–2023, nhu cầu chăm sóc tinh thần tăng cao. Không
            gian thiên nhiên đóng vai trò như “liệu pháp trị liệu” tự nhiên.
          </p>
        </li>

        <li>
          <p class="text-[18px] font-semibold text-[#2e2e2e] mb-1">
            • Bất động sản nghỉ dưỡng truyền thống chững lại, second home rừng
            trỗi dậy
          </p>
          <p class="text-[#4a4a4a] text-[17px] leading-relaxed pl-3">
            Biệt thự biển và condotel giảm hấp dẫn do chi phí cao và pháp lý
            phức tạp. Ngược lại, second home núi – rừng có giá mềm hơn, dễ sở
            hữu và phù hợp cả nghỉ dưỡng lẫn khai thác lưu trú.
          </p>
        </li>
      </ul>
    </div>
    <div class="w-full flex justify-center mt-2">
      <img
        src="/images/news/thiet-ke-nha-vuon-2000m2-32.png"
        alt="Second Home"
        class="w-[1000px] h-auto object-cover rounded"
      />
    </div>
  </section>

  <section class="w-full py-20 font-mont">
    <div class="max-w-6xl mx-auto px-4">
      <h2 class="font-bold text-[22px] md:text-[24px] text-[#2e2e2e] mb-8">
        2. NHỮNG MÔ HÌNH SECOND HOME ĐANG “LÊN NGÔI”
      </h2>

      <p class="text-[#404040] text-[18px] leading-relaxed mb-10">
        Ngày càng nhiều chủ đầu tư cá nhân và nhà đầu tư nhỏ lẻ chọn các mô
        hình:
      </p>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-20">
        <ul class="space-y-8 pl-6">
          <li>
            <p class="text-[18px] font-semibold text-[#2e2e2e] mb-1">
              • Cabin gỗ (Wooden Cabin / A-frame House)
            </p>
            <p class="text-[#4a4a4a] text-[17px] leading-relaxed pl-3">
              Thiết kế nhỏ gọn 30–60m², ẩn mình trong rừng, chi phí xây thấp,
              phù hợp để ở hoặc cho thuê.
            </p>
          </li>

          <li>
            <p class="text-[18px] font-semibold text-[#2e2e2e] mb-1">
              • Farmstay mini 500–3000m²
            </p>
            <p class="text-[#4a4a4a] text-[17px] leading-relaxed pl-3">
              Kết hợp nghỉ dưỡng + nông trại nhỏ. Đặc biệt phổ biến tại Lâm
              Đồng, Bảo Lộc, Hòa Bình.
            </p>
          </li>

          <li>
            <p class="text-[18px] font-semibold text-[#2e2e2e] mb-1">
              • Homestay ven hồ – ven suối
            </p>
            <p class="text-[#4a4a4a] text-[17px] leading-relaxed pl-3">
              Cảnh quan nước giúp tạo giá trị cảm xúc và thu hút khách du lịch
              cuối tuần.
            </p>
          </li>
        </ul>

        <ul class="space-y-8 pl-6">
          <li>
            <p class="text-[18px] font-semibold text-[#2e2e2e] mb-1">
              • Nhà vườn nghỉ dưỡng
            </p>
            <p class="text-[#4a4a4a] text-[17px] leading-relaxed pl-3">
              Không gian rộng, phù hợp để cả gia đình nghỉ ngơi mỗi cuối tuần mà
              không cần di chuyển xa.
            </p>
          </li>

          <li>
            <p class="text-[18px] font-semibold text-[#2e2e2e] mb-1">
              • Bungalow retreat – khu biệt lập mini
            </p>
            <p class="text-[#4a4a4a] text-[17px] leading-relaxed pl-3">
              Dành cho người thích sự riêng tư, yên tĩnh hoàn toàn khỏi đô thị.
            </p>
          </li>
        </ul>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 justify-center">
        <img
          src="/images/news/tintucthitruong-2.png"
          alt="Farmstay Image"
          class="w-full h-auto object-cover"
        />

        <img
          src="/images/news/tintucthitruong-3.png"
          alt="Bungalow Image"
          class="w-full h-auto object-cover"
        />
      </div>
    </div>
  </section>

  <section class="w-full font-mont">
    <div class="max-w-6xl mx-auto px-4">
      <h2 class="font-bold text-[22px] md:text-[24px] text-[#2e2e2e] mb-6">
        3. TẠI SAO SECOND HOME RỪNG HẤP DẪN NHÀ ĐẦU TƯ?
      </h2>

      <p class="text-[#404040] text-[18px] leading-relaxed mb-10">
        Xu hướng second home rừng không chỉ tăng về mặt nhu cầu trải nghiệm, mà
        còn trở thành một phân khúc đầu tư có khả năng sinh lợi ổn định. Dưới
        đây là những lý do giúp dòng sản phẩm này đặc biệt thu hút nhà đầu tư
        trong giai đoạn 2024–2025:
      </p>

      <div class="space-y-10">
        <div>
          <p class="text-[18px] font-semibold text-[#2e2e2e] mb-3">
            1. Chi phí đầu tư ban đầu thấp hơn nhiều phân khúc khác
          </p>

          <p class="text-[#4a4a4a] text-[17px] leading-relaxed mb-4">
            So với biệt thự biển, condotel hoặc nhà phố trung tâm, second home
            rừng có mức chi phí đầu vào dễ chịu hơn rất nhiều.
          </p>

          <ul
            class="space-y-2 text-[#4a4a4a] text-[17px] leading-relaxed pl-10 list-disc"
          >
            <li>
              Giá đất ở các khu vực ven rừng, ven suối hoặc ngoại ô thường mềm
              hơn 30–70%.
            </li>
            <li>
              Thiết kế nhà gỗ, cabin hoặc A-frame giúp giảm đáng kể tổng mức đầu
              tư.
            </li>
            <li>
              Chi phí vận hành thấp, ít rủi ro thị trường hơn so với các mô hình
              nghỉ dưỡng truyền thống.
            </li>
          </ul>

          <p class="text-[#4a4a4a] text-[17px] leading-relaxed mt-4">
            Điều này mở ra cơ hội cho cả nhà đầu tư mới, nhà đầu tư vốn nhỏ chứ
            không chỉ người sở hữu tài chính lớn.
          </p>
        </div>

        <div>
          <p class="text-[18px] font-semibold text-[#2e2e2e] mb-3">
            2. Tỷ suất khai thác phòng cao nhờ nhu cầu du lịch cuối tuần bùng nổ
          </p>

          <p class="text-[#4a4a4a] text-[17px] leading-relaxed mb-3">
            Du lịch “ngắn ngày – gần thành phố – về với thiên nhiên” đang phát
            triển vượt trội. Khách hàng chủ yếu là:
          </p>

          <ul
            class="space-y-2 text-[#4a4a4a] text-[17px] leading-relaxed pl-10 list-disc"
          >
            <li>Nhóm trẻ tìm nơi “trốn phố”,</li>
            <li>Các cặp đôi, gia đình nhỏ,</li>
            <li>Nhân viên văn phòng muốn đổi gió cuối tuần.</li>
          </ul>

          <p class="text-[#4a4a4a] text-[17px] leading-relaxed mt-4">
            Điều này giúp các mô hình second home rừng ghi nhận tỷ suất khai
            thác cao, đặc biệt từ thứ Sáu đến Chủ Nhật. Nhiều khu vực gần Hà Nội
            và TP.HCM có tỉ lệ lấp phòng 60–85% đều đặn, thậm chí kín 100% vào
            các dịp lễ.
          </p>
        </div>

        <div>
          <p class="text-[18px] font-semibold text-[#2e2e2e] mb-3">
            3. Kiến trúc linhw-full py-20 hoạt – thi công nhanh – thu hồi vốn
            sớm
          </p>

          <p class="text-[#4a4a4a] text-[17px] leading-relaxed mb-4">
            Một trong những lợi thế của second home rừng là đa dạng kiến trúc,
            phù hợp nhiều mức tài chính. Những mô hình này có điểm chung:
          </p>

          <ul
            class="space-y-2 text-[#4a4a4a] text-[17px] leading-relaxed pl-10 list-disc"
          >
            <li>Thời gian thi công nhanh (1–3 tháng)</li>
            <li>Chi phí rẻ</li>
            <li>Dễ bảo trì</li>
            <li>Thẩm mỹ cao, thu hút khách du lịch</li>
          </ul>

          <p class="text-[#4a4a4a] text-[17px] leading-relaxed mt-4">
            Điều này cho phép nhà đầu tư ra hàng nhanh, khai thác sớm, dòng tiền
            quay vòng tốt. Nhờ khả năng đa dạng hóa mô hình kinh doanh, nhà đầu
            tư có thể tối ưu doanh thu và mở rộng dịch vụ mà không tốn quá nhiều
            chi phí cố định.
          </p>

          <p class="text-[#4a4a4a] text-[17px] leading-relaxed mt-4">
            Điều này phản ánh sức hút mạnh mẽ và ổn định của phân khúc second
            home rừng, bất chấp thị trường bất động sản chung có thể biến động.
          </p>
        </div>
      </div>
      <div class="max-w-6xl mx-auto mt-16 pb-10 font-mont">
        <NewsGallery :images="news.gallery" />
      </div>
    </div>

    <div class="max-w-6xl mx-auto pt-12 px-4">
      <h2
        class="uppercase font-bold text-[22px] md:text-[24px] text-[#2e2e2e] mb-6"
      >
        4. Kết luận
      </h2>

      <p class="text-[#404040] text-[18px] leading-relaxed mb-10">
        Xu hướng “bỏ phố về rừng” không chỉ là trào lưu ngắn hạn, mà đang trở
        thành một lựa chọn sống bền vững, lâu dài của người Việt hiện đại.
        Second home không còn là “xa xỉ phẩm”, mà trở thành phương án cân bằng
        cuộc sống, đầu tư thông minh và là cánh cửa mở ra một phong cách sống
        gần thiên nhiên hơn.
      </p>
    </div>
  </section>

  <!-- SECTION: TIN TỨC KHÁC -->
  <section class="w-full pb-20 font-mont">
    <div class="max-w-6xl mx-auto px-4">
      <!-- Top line -->
      <div class="w-[80%] border-t border-[#D9D9D9] mb-8 mx-auto"></div>

      <!-- Header row -->
      <div class="flex items-center justify-between mb-10">
        <h2
          class="font-banque font-bold text-[20px] md:text-[22px] text-[#2e2e2e] uppercase tracking-wide"
        >
          TIN TỨC KHÁC
        </h2>

        <a
          href="/news"
          class="text-[14px] font-semibold uppercase text-[#7f7f7f] hover:text-[#9B1C1C] cursor-pointer"
        >
          Xem tất cả >>
        </a>
      </div>

      <!-- NEWS LIST -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <div
          v-for="(item, idx) in relatedNews"
          :key="idx"
          class="cursor-pointer font-mont"
        >
          <!-- Thumbnail -->
          <div
            class="mb-8 w-[480px] h-[240px] bg-[#e3e3e3] border-4 border-[#cfcfcf] shadow-[inset_0_2px_4px_rgba(255,255,255,0.6),inset_0_-2px_6px_rgba(0,0,0,0.15)] overflow-hidden"
          >
            <img :src="item.image" alt="" class="w-full h-full object-cover" />
          </div>

          <!-- Title -->
          <h3
            class="text-[#9B1C1C] font-bold text-[18px] text-justify uppercase leading-snug mb-2"
          >
            {{ item.title }}
          </h3>

          <!-- Excerpt -->
          <p
            class="w-[480px] text-[#4a4a4a] text-[16px] text-justify leading-relaxed"
          >
            {{ item.excerpt }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import Layouts from "../../../layouts/client.vue";
import NewsGallery  from "../../../components/client/NewsGallery.vue"
import { usePage } from "@inertiajs/vue3";

defineOptions({
  layout: Layouts,
});

const page = usePage();

const news = page.props.news;
const relatedNews = page.props.relatedNews;

console.log(news);
</script>

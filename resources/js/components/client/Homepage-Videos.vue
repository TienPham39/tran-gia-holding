<template>
  <section class="py-0">
    <div class="container mx-auto">

      <!-- Full-bleed video -->
      <div class="relative left-1/2 -ml-[50vw] w-screen z-0">
        <div class="w-screen bg-black relative z-0">
          <video
            ref="mainVideo"
            :src="activeVideo.url"
            playsinline
            class="w-full h-[420px] object-cover bg-black cursor-pointer"
            @play="onPlay"
            @pause="onPause"
            @click="isPlaying ? mainVideo.pause() : togglePlay()"
          ></video>

          <!-- Play button overlay -->
          <button
            v-if="!isPlaying"
            @click="togglePlay"
            class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-10 bg-transparent border-0 p-0"
            aria-label="Play video"
          >
            <img :src="playBtn" alt="Play" class="w-20 h-20 object-contain" />
          </button>
        </div>
      </div>

      <!-- Full-bleed thumbnails -->
      <div class="relative left-1/2 -ml-[50vw] w-screen z-0">
        <div class="bg-[#670000] relative z-0">
          <!-- Top gradient fade -->
          <div class="absolute left-0 right-0 h-[120px] pointer-events-none z-20 top-0 bg-[linear-gradient(180deg,rgba(103,0,0,1)_0%,rgba(103,0,0,0.95)_10%,rgba(103,0,0,0.8)_30%,rgba(103,0,0,0.5)_60%,rgba(103,0,0,0)_100%)]"></div>

          <div
            ref="scrollContainer"
            class="w-full px-4 lg:px-8 overflow-y-auto scroll-smooth max-h-[600px] scrollbar scrollbar-thumb-white/30 scrollbar-track-black/20 scrollbar-thin z-10"
            @mousemove="handleMouseMove"
            @mouseleave="stopAutoScroll"
          >
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
              <!-- Left column -->
              <div class="left-column flex flex-col gap-4">
                <div
                  v-for="item in columns[0]"
                  :key="item.video.id"
                  class="relative z-10 bg-black/20 cursor-pointer rounded-md overflow-hidden transition-transform duration-200 hover:scale-105 hover:shadow-lg"
                  :class="{ 'ring-4 ring-white ring-opacity-40': activeIndex === item.idx }"
                  @click="playVideo(item.idx)"
                >
              <img :src="item.video.thumb" :alt="item.video.title" :class="['w-full', item.full ? 'h-[600px]' : 'h-48', 'object-cover']" />
                </div>
              </div>

              <!-- Center column (logo + images) -->
              <div class="center-column flex flex-col gap-4">
                <div class="flex flex-col items-center relative z-[150]">
                  <img src="/images/homepage/footer_logo.png" alt="Trần Gia Holding" class="h-32 md:h-28 w-auto" />
                </div>

                <div
                  v-for="(item, i) in columns[1]"
                  :key="item.video.id"
                  class="relative z-10 bg-black/20 cursor-pointer rounded-md overflow-hidden transition-transform duration-200 hover:scale-105"
                  :class="{ 'ring-4 ring-white ring-opacity-40': activeIndex === item.idx, 'h-80': i === 1 }"
                  @click="playVideo(item.idx)"
                >
              <img :src="item.video.thumb" :alt="item.video.title" :class="['w-full', item.full ? 'h-[600px]' : (i === 1 ? 'h-80' : 'h-48'), 'object-cover']" />
                </div>
              </div>

              <!-- Right column -->
              <div class="right-column flex flex-col gap-4">
                <div
                  v-for="item in columns[2]"
                  :key="item.video.id"
                  class="relative z-10 bg-black/20 cursor-pointer rounded-md overflow-hidden transition-transform duration-200 hover:scale-105 hover:shadow-lg"
                  :class="{ 'ring-4 ring-white ring-opacity-40': activeIndex === item.idx }"
                  @click="playVideo(item.idx)"
                >
              <img :src="item.video.thumb" :alt="item.video.title" :class="['w-full', item.full ? 'h-[600px]' : 'h-48', 'object-cover']" />
                </div>
              </div>
            </div>
          </div>

          <!-- Bottom gradient fade -->
          <div class="absolute left-0 right-0 h-[120px] pointer-events-none z-20 bottom-0 bg-[linear-gradient(0deg,rgba(103,0,0,1)_0%,rgba(103,0,0,0.95)_10%,rgba(103,0,0,0.8)_30%,rgba(103,0,0,0.5)_60%,rgba(103,0,0,0)_100%)]"></div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, nextTick } from 'vue'

// Vite-friendly imports of assets
const imageFiles = [
  'Holding.png',
  'Holding2.png',
  'Holding3.png',
  'Holding4.png',
  'Holding6.png',
  'Holding7.png',
  'Holding8.png',
  'Holding9.png',
]

const videoFile = new URL('../../../assets/images/homepage-videos/Video.mp4', import.meta.url).href
const playBtn = new URL('../../../assets/images/homepage-videos/Playvideo.png', import.meta.url).href

const videos = imageFiles.map((name, i) => ({
  id: i + 1,
  title: 'Trần Gia Holding',
  url: videoFile,
  thumb: new URL(`../../../assets/images/homepage-videos/${name}`, import.meta.url).href,
}))

// New distribution: left 2 full, middle 4, right 2 full (8 images)
// Left: indexes 0,1 (Holding1, Holding2) — full
// Middle: indexes 2,3,4,5 (Holding3, Holding4, Holding6, Holding7)
// Right: indexes 6,7 (Holding8, Holding9) — full
const columns = [[], [], []]
const leftSet = new Set([0, 1])
const middleSet = new Set([2, 3, 4, 5])
const rightSet = new Set([6, 7])
const fullHeightSet = new Set([0, 1, 6, 7])

videos.forEach((v, i) => {
  const item = { video: v, idx: i, full: fullHeightSet.has(i) }
  if (leftSet.has(i)) columns[0].push(item)
  else if (middleSet.has(i)) columns[1].push(item)
  else if (rightSet.has(i)) columns[2].push(item)
  else columns[2].push(item)
})

const activeIndex = ref(0)
const activeVideo = computed(() => videos[activeIndex.value])
const mainVideo = ref(null)
const scrollContainer = ref(null)
const isPlaying = ref(false)

let scrollRaf = null

const handleMouseMove = (e) => {
  if (!scrollContainer.value) return
  
  const container = scrollContainer.value
  const rect = container.getBoundingClientRect()
  const mouseY = e.clientY - rect.top
  const containerHeight = rect.height

  // Vùng trigger (45% top và bottom)
  const triggerZone = containerHeight * 0.45
  
  if (mouseY < triggerZone) {
    // Hover phía trên -> scroll lên
    startAutoScroll('up', (triggerZone - mouseY) / triggerZone)
  } else if (mouseY > containerHeight - triggerZone) {
    // Hover phía dưới -> scroll xuống
    startAutoScroll('down', (mouseY - (containerHeight - triggerZone)) / triggerZone)
  } else {
    // Ở giữa -> dừng scroll
    stopAutoScroll()
  }
}

const startAutoScroll = (direction, intensity) => {
  if (scrollRaf) return // Đã đang scroll
  
  const scroll = () => {
    if (!scrollContainer.value) {
      stopAutoScroll()
      return
    }

    const speed = intensity * 60 // Tốc độ tối đa 60px/frame

    if (direction === 'up') {
      scrollContainer.value.scrollTop -= speed
    } else {
      scrollContainer.value.scrollTop += speed
    }
    
    scrollRaf = requestAnimationFrame(scroll)
  }
  
  scrollRaf = requestAnimationFrame(scroll)
}

const stopAutoScroll = () => {
  if (scrollRaf) {
    cancelAnimationFrame(scrollRaf)
    scrollRaf = null
  }
}

const playVideo = (idx) => {
  activeIndex.value = idx
  // Không tự động play, chỉ đổi video source
  // pause current video and reset playing state so user can click play overlay
  nextTick(() => {
    if (mainVideo.value) {
      mainVideo.value.pause()
      mainVideo.value.currentTime = 0
      isPlaying.value = false
    }
  })
}

const togglePlay = async () => {
  if (!mainVideo.value) return
  try {
    await mainVideo.value.play()
    // if play succeeds, isPlaying will be set by onPlay
  } catch (e) {
    // autoplay blocked or error — set isPlaying if video is already playing
    isPlaying.value = !mainVideo.value.paused
  }
}

const onPlay = () => {
  isPlaying.value = true
}

const onPause = () => {
  isPlaying.value = false
}
</script>

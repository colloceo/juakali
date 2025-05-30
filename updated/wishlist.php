<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Plus+Jakarta+Sans%3Awght%40400%3B500%3B700%3B800"
    />

    <title>Stitch Design</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  </head>
  <body>
    <div class="relative flex size-full min-h-screen flex-col bg-white group/design-root overflow-x-hidden" style='font-family: "Plus Jakarta Sans", "Noto Sans", sans-serif;'>
      <div class="layout-container flex h-full grow flex-col">
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#f4f2f0] px-10 py-3">
          <div class="flex items-center gap-8">
            <div class="flex items-center gap-4 text-[#181411]">
              <div class="size-4">
                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M4 42.4379C4 42.4379 14.0962 36.0744 24 41.1692C35.0664 46.8624 44 42.2078 44 42.2078L44 7.01134C44 7.01134 35.068 11.6577 24.0031 5.96913C14.0971 0.876274 4 7.27094 4 7.27094L4 42.4379Z"
                    fill="currentColor"
                  ></path>
                </svg>
              </div>
              <h2 class="text-[#181411] text-lg font-bold leading-tight tracking-[-0.015em]">Crafts of Kenya</h2>
            </div>
            <div class="flex items-center gap-9">
              <a class="text-[#181411] text-sm font-medium leading-normal" href="#">New Arrivals</a>
              <a class="text-[#181411] text-sm font-medium leading-normal" href="#">Best Sellers</a>
              <a class="text-[#181411] text-sm font-medium leading-normal" href="#">Categories</a>
              <a class="text-[#181411] text-sm font-medium leading-normal" href="#">About Us</a>
            </div>
          </div>
          <div class="flex flex-1 justify-end gap-8">
            <label class="flex flex-col min-w-40 !h-10 max-w-64">
              <div class="flex w-full flex-1 items-stretch rounded-xl h-full">
                <div
                  class="text-[#897461] flex border-none bg-[#f4f2f0] items-center justify-center pl-4 rounded-l-xl border-r-0"
                  data-icon="MagnifyingGlass"
                  data-size="24px"
                  data-weight="regular"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                    <path
                      d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"
                    ></path>
                  </svg>
                </div>
                <input
                  placeholder="Search"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#181411] focus:outline-0 focus:ring-0 border-none bg-[#f4f2f0] focus:border-none h-full placeholder:text-[#897461] px-4 rounded-l-none border-l-0 pl-2 text-base font-normal leading-normal"
                  value=""
                />
              </div>
            </label>
            <div class="flex gap-2">
              <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#f4f2f0] text-[#181411] text-sm font-bold leading-normal tracking-[0.015em]"
              >
                <span class="truncate">Cart</span>
              </button>
              <button
                class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 bg-[#f4f2f0] text-[#181411] gap-2 text-sm font-bold leading-normal tracking-[0.015em] min-w-0 px-2.5"
              >
                <div class="text-[#181411]" data-icon="Heart" data-size="20px" data-weight="regular">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                    <path
                      d="M178,32c-20.65,0-38.73,8.88-50,23.89C116.73,40.88,98.65,32,78,32A62.07,62.07,0,0,0,16,94c0,70,103.79,126.66,108.21,129a8,8,0,0,0,7.58,0C136.21,220.66,240,164,240,94A62.07,62.07,0,0,0,178,32ZM128,206.8C109.74,196.16,32,147.69,32,94A46.06,46.06,0,0,1,78,48c19.45,0,35.78,10.36,42.6,27a8,8,0,0,0,14.8,0c6.82-16.67,23.15-27,42.6-27a46.06,46.06,0,0,1,46,46C224,147.61,146.24,196.15,128,206.8Z"
                    ></path>
                  </svg>
                </div>
              </button>
            </div>
            <div
              class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
              style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuA_o3l194PLcm8piaInzdpAGh-I7cgLnhSlErqsJplDAcubb3FVvx-VqgCakhc-G456Xtx7viFbGR5zJaduqm26aAQh7tQ8wVpykFNJ4n2iFoKWtGRmEt2ZmHyA2Btphz3YeVT4aJrAFD-4GIOYzSo7QdPQv8Rg-n9_QqrHUxBP8gcj-hdOuhncr66Ng8oFGKQ5g4iQ_o8fiNEDOJ4483RFDVa-6is4tU13i3rU10qxBq3gODaEz5BhiWCIS9D1W1vC7DjSJaHF5j0");'
            ></div>
          </div>
        </header>
        <div class="px-40 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4"><p class="text-[#181411] tracking-light text-[32px] font-bold leading-tight min-w-72">My Wishlist</p></div>
            <div class="p-4">
              <div class="flex items-stretch justify-between gap-4 rounded-xl">
                <div class="flex flex-col gap-1 flex-[2_2_0px]">
                  <p class="text-[#897461] text-sm font-normal leading-normal">Handmade Basket</p>
                  <p class="text-[#181411] text-base font-bold leading-tight">Kiondo Basket</p>
                  <p class="text-[#897461] text-sm font-normal leading-normal">Ksh 1,500</p>
                </div>
                <div
                  class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl flex-1"
                  style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDG-9tpjStshiJOo8p5B3jqaggggBgPjVyH_y-UnEovyTAk_Hm2qMCCRXxDeZ1T5rUiDpsVDkbs-XJOvvdVhykjYV8b1oyaVsJVnoLekf5ufuKGBW7U-vmwK_np_P-DPZkgdAAXLVTfOKl6n203z7XqsCFczZEmHGNp0PKpH_6_NVPdgfaMwJXVjmpB-CoN8W4ePV8W-nqgj3XQMifqzVrDqS2utDkVa9c6ZEiv_kUsZ2Xg7g7Aw3nBhTHXC5cWjsZjzOc2S8rRQBg");'
                ></div>
              </div>
            </div>
            <div class="p-4">
              <div class="flex items-stretch justify-between gap-4 rounded-xl">
                <div class="flex flex-col gap-1 flex-[2_2_0px]">
                  <p class="text-[#897461] text-sm font-normal leading-normal">Wooden Sculpture</p>
                  <p class="text-[#181411] text-base font-bold leading-tight">Maasai Warrior Carving</p>
                  <p class="text-[#897461] text-sm font-normal leading-normal">Ksh 2,000</p>
                </div>
                <div
                  class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl flex-1"
                  style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDbAi4FTKT3DxKfauUuM7sMv2XxmaIqzbIj3M9fSCPKEexMy7Ssy1TJ-gdJz-exhPFJmgXNyrGka59V9eC8KbzZbLI4lfnX4xxIFgl1zaJdeBCy0bF0ooVTJ9HogCi8ozUUW4fGokbr0TKYf7py6ZPn3iWxl0mjFwrLiT8b3y2NcsJVpOu8nJ0XJdspj32hK4q5fMM5lF-Dr9lLmfIKaKlqp1_ZHhCNAH85PL8T3Vm5g6mg3GQP8SsbbqqboFFiUsiOaljtmwV7pIM");'
                ></div>
              </div>
            </div>
            <div class="p-4">
              <div class="flex items-stretch justify-between gap-4 rounded-xl">
                <div class="flex flex-col gap-1 flex-[2_2_0px]">
                  <p class="text-[#897461] text-sm font-normal leading-normal">Beaded Jewelry</p>
                  <p class="text-[#181411] text-base font-bold leading-tight">Samburu Necklace</p>
                  <p class="text-[#897461] text-sm font-normal leading-normal">Ksh 800</p>
                </div>
                <div
                  class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl flex-1"
                  style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBX_n1v2sEj5vz1GcRvao_aKk3zwS7wfw_1sNNoxdNjAzxaMV8f54k0Apg8QZ_lJAs3ho0V2DyDZFTu7zVB0QVDgOF7R_pjCO0Nb9KPtO3B2xMHoChFh9P7EOA3wk-ipRmz3AzvwGGDYxBX3-AdNpLPrcfahqUzYOJYY2DZ5JlJr4FmdPTmvHySQvNAUl1GM2vXqsF6TFc5nAIY0Xhkvx344PhOv6UUo2jORII2orxOI1N21lp-Ya_ioNhvXFAuzJ4gFnB7Ii-eJXA");'
                ></div>
              </div>
            </div>
            <div class="p-4">
              <div class="flex items-stretch justify-between gap-4 rounded-xl">
                <div class="flex flex-col gap-1 flex-[2_2_0px]">
                  <p class="text-[#897461] text-sm font-normal leading-normal">Textile Art</p>
                  <p class="text-[#181411] text-base font-bold leading-tight">Kitenge Fabric</p>
                  <p class="text-[#897461] text-sm font-normal leading-normal">Ksh 1,200</p>
                </div>
                <div
                  class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl flex-1"
                  style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuC7d4tSG_KXfWZ7EWDRwU7g7OarufdPUYX4qNsn5ghiLsOCbaSFSgCmkAM6YTp_aaooz_i9k86ZdhFHZ0qISuBmvNajnGewBmrNt1WHtbsEDY7YABQ-8IH2_mVDuwlImZxEHIQgACkM9t42GxvG6jcO0pB76inXzrxWo996cMeY_-Jomzz9dZvDgKlUy7PB3zjAAPkqebz8E2hu__PNa6xgbU2Ca3k_ajd2UssZC4iUEq7SsFVRiDvr_roiLM5eH_1HX6fFVAdDXK4");'
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

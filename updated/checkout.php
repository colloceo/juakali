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
    <div
      class="relative flex size-full min-h-screen flex-col bg-white group/design-root overflow-x-hidden"
      style='--radio-dot-svg: url(&apos;data:image/svg+xml,%3csvg viewBox=%270 0 16 16%27 fill=%27rgb(22,20,18)%27 xmlns=%27http://www.w3.org/2000/svg%27%3e%3ccircle cx=%278%27 cy=%278%27 r=%273%27/%3e%3c/svg%3e&apos;); font-family: "Plus Jakarta Sans", "Noto Sans", sans-serif;'
    >
      <div class="layout-container flex h-full grow flex-col">
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#f4f2f1] px-10 py-3">
          <div class="flex items-center gap-4 text-[#161412]">
            <div class="size-4">
              <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z"
                  fill="currentColor"
                ></path>
              </svg>
            </div>
            <h2 class="text-[#161412] text-lg font-bold leading-tight tracking-[-0.015em]">Safari Market</h2>
          </div>
          <div class="flex flex-1 justify-end gap-8">
            <div class="flex items-center gap-9">
              <a class="text-[#161412] text-sm font-medium leading-normal" href="#">Shop</a>
              <a class="text-[#161412] text-sm font-medium leading-normal" href="#">About</a>
              <a class="text-[#161412] text-sm font-medium leading-normal" href="#">Contact</a>
            </div>
            <button
              class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 bg-[#f4f2f1] text-[#161412] gap-2 text-sm font-bold leading-normal tracking-[0.015em] min-w-0 px-2.5"
            >
              <div class="text-[#161412]" data-icon="ShoppingCart" data-size="20px" data-weight="regular">
                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                  <path
                    d="M222.14,58.87A8,8,0,0,0,216,56H54.68L49.79,29.14A16,16,0,0,0,34.05,16H16a8,8,0,0,0,0,16h18L59.56,172.29a24,24,0,0,0,5.33,11.27,28,28,0,1,0,44.4,8.44h45.42A27.75,27.75,0,0,0,152,204a28,28,0,1,0,28-28H83.17a8,8,0,0,1-7.87-6.57L72.13,152h116a24,24,0,0,0,23.61-19.71l12.16-66.86A8,8,0,0,0,222.14,58.87ZM96,204a12,12,0,1,1-12-12A12,12,0,0,1,96,204Zm96,0a12,12,0,1,1-12-12A12,12,0,0,1,192,204Zm4-74.57A8,8,0,0,1,188.1,136H69.22L57.59,72H206.41Z"
                  ></path>
                </svg>
              </div>
            </button>
          </div>
        </header>
        <div class="px-40 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-wrap gap-2 p-4">
              <a class="text-[#81756a] text-base font-medium leading-normal" href="#">Cart</a>
              <span class="text-[#81756a] text-base font-medium leading-normal">/</span>
              <span class="text-[#161412] text-base font-medium leading-normal">Checkout</span>
            </div>
            <div class="flex flex-wrap justify-between gap-3 p-4"><p class="text-[#161412] tracking-light text-[32px] font-bold leading-tight min-w-72">Checkout</p></div>
            <h3 class="text-[#161412] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Shipping Address</h3>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#161412] text-base font-medium leading-normal pb-2">Full Name</p>
                <input
                  placeholder="Enter your full name"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#161412] focus:outline-0 focus:ring-0 border border-[#e3e0dd] bg-white focus:border-[#e3e0dd] h-14 placeholder:text-[#81756a] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#161412] text-base font-medium leading-normal pb-2">Address</p>
                <input
                  placeholder="Enter your address"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#161412] focus:outline-0 focus:ring-0 border border-[#e3e0dd] bg-white focus:border-[#e3e0dd] h-14 placeholder:text-[#81756a] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#161412] text-base font-medium leading-normal pb-2">City</p>
                <input
                  placeholder="Enter your city"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#161412] focus:outline-0 focus:ring-0 border border-[#e3e0dd] bg-white focus:border-[#e3e0dd] h-14 placeholder:text-[#81756a] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#161412] text-base font-medium leading-normal pb-2">Postal Code</p>
                <input
                  placeholder="Enter your postal code"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#161412] focus:outline-0 focus:ring-0 border border-[#e3e0dd] bg-white focus:border-[#e3e0dd] h-14 placeholder:text-[#81756a] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#161412] text-base font-medium leading-normal pb-2">Country</p>
                <input
                  placeholder="Enter your country"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#161412] focus:outline-0 focus:ring-0 border border-[#e3e0dd] bg-white focus:border-[#e3e0dd] h-14 placeholder:text-[#81756a] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <h3 class="text-[#161412] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Billing Information (Visible only when Card Payment is selected)</h3>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#161412] text-base font-medium leading-normal pb-2">Full Name</p>
                <input
                  placeholder="Enter your full name"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#161412] focus:outline-0 focus:ring-0 border border-[#e3e0dd] bg-white focus:border-[#e3e0dd] h-14 placeholder:text-[#81756a] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#161412] text-base font-medium leading-normal pb-2">Address</p>
                <input
                  placeholder="Enter your address"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#161412] focus:outline-0 focus:ring-0 border border-[#e3e0dd] bg-white focus:border-[#e3e0dd] h-14 placeholder:text-[#81756a] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#161412] text-base font-medium leading-normal pb-2">City</p>
                <input
                  placeholder="Enter your city"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#161412] focus:outline-0 focus:ring-0 border border-[#e3e0dd] bg-white focus:border-[#e3e0dd] h-14 placeholder:text-[#81756a] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#161412] text-base font-medium leading-normal pb-2">Postal Code</p>
                <input
                  placeholder="Enter your postal code"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#161412] focus:outline-0 focus:ring-0 border border-[#e3e0dd] bg-white focus:border-[#e3e0dd] h-14 placeholder:text-[#81756a] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#161412] text-base font-medium leading-normal pb-2">Country</p>
                <input
                  placeholder="Enter your country"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#161412] focus:outline-0 focus:ring-0 border border-[#e3e0dd] bg-white focus:border-[#e3e0dd] h-14 placeholder:text-[#81756a] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <h3 class="text-[#161412] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Payment Options</h3>
            <div class="flex flex-col gap-3 p-4">
              <label class="flex items-center gap-4 rounded-xl border border-solid border-[#e3e0dd] p-[15px]">
                <input
                  type="radio"
                  class="h-5 w-5 border-2 border-[#e3e0dd] bg-transparent text-transparent checked:border-[#161412] checked:bg-[image:--radio-dot-svg] focus:outline-none focus:ring-0 focus:ring-offset-0 checked:focus:border-[#161412]"
                  name="8212e75a-b476-42e7-ad5e-0f133023f101"
                  checked=""
                />
                <div class="flex grow flex-col"><p class="text-[#161412] text-sm font-medium leading-normal">Mpesa</p></div>
              </label>
              <label class="flex items-center gap-4 rounded-xl border border-solid border-[#e3e0dd] p-[15px]">
                <input
                  type="radio"
                  class="h-5 w-5 border-2 border-[#e3e0dd] bg-transparent text-transparent checked:border-[#161412] checked:bg-[image:--radio-dot-svg] focus:outline-none focus:ring-0 focus:ring-offset-0 checked:focus:border-[#161412]"
                  name="8212e75a-b476-42e7-ad5e-0f133023f101"
                />
                <div class="flex grow flex-col"><p class="text-[#161412] text-sm font-medium leading-normal">Card Payment</p></div>
              </label>
              <label class="flex items-center gap-4 rounded-xl border border-solid border-[#e3e0dd] p-[15px]">
                <input
                  type="radio"
                  class="h-5 w-5 border-2 border-[#e3e0dd] bg-transparent text-transparent checked:border-[#161412] checked:bg-[image:--radio-dot-svg] focus:outline-none focus:ring-0 focus:ring-offset-0 checked:focus:border-[#161412]"
                  name="8212e75a-b476-42e7-ad5e-0f133023f101"
                />
                <div class="flex grow flex-col"><p class="text-[#161412] text-sm font-medium leading-normal">PayPal</p></div>
              </label>
            </div>
            <h3 class="text-[#161412] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Order Summary</h3>
            <div class="flex items-center gap-4 bg-white px-4 min-h-[72px] py-2">
              <div
                class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg size-14"
                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBJi74d1_ewpf_vE0vfQlrt_K8GaHer3xJpFghD_-G4UHa57WBZKEqVDf8Bv93Mb2OgwDOSQ3XuwFEiPL_jRSyfdcOLi4_mvxyXqc5g_7ZCBtqzCXpKXcRf5YjvZ6PdHjAnhV9UEFHDc1tVX0t7-iKLvbl9G6cEa9B5VzW_ZF-zz-_nRz46CWS6xGPgPflkaN0YOfTKV77LqDhwnSmxxz-TdIrWu2ZsmYsu2OIQ3OlWI5i8A1ChfMH5Dm6sLP9DcFvite4uDoifLH8");'
              ></div>
              <div class="flex flex-col justify-center">
                <p class="text-[#161412] text-base font-medium leading-normal line-clamp-1">Handwoven Basket</p>
                <p class="text-[#81756a] text-sm font-normal leading-normal line-clamp-2">Quantity: 2</p>
              </div>
            </div>
            <div class="flex items-center gap-4 bg-white px-4 min-h-[72px] py-2">
              <div
                class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg size-14"
                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD6Ky6Ly1cHK22umX52umwO7ym0ZXFo6aogHVuRxeQfPLlHFEtyzxPq9dAzTIrMDtF9SVKBnT5s9s_hTlNZbSNGK-3qZilt68CT5_st24Fsj5_ezugUZac5YLhV_RDeiWPDJDbVMa6gOQRO2Yh4YtAFx8lRaI3WVOaaHu-VDtPls66xM6aH4c0wBOkAlaZzNWgFepZvu8vo4LBLoM-sZo5V0KTujr6P-a2L-5C62i0Ih_hm8r9QJhWT_kljSdB6Egcv2vq2_kWAW4I");'
              ></div>
              <div class="flex flex-col justify-center">
                <p class="text-[#161412] text-base font-medium leading-normal line-clamp-1">Kenyan Coffee Beans</p>
                <p class="text-[#81756a] text-sm font-normal leading-normal line-clamp-2">Quantity: 1</p>
              </div>
            </div>
            <div class="flex items-center gap-4 bg-white px-4 min-h-14 justify-between">
              <p class="text-[#161412] text-base font-normal leading-normal flex-1 truncate">Subtotal</p>
              <div class="shrink-0"><p class="text-[#161412] text-base font-normal leading-normal">KSH 55.00</p></div>
            </div>
            <div class="flex items-center gap-4 bg-white px-4 min-h-14 justify-between">
              <p class="text-[#161412] text-base font-normal leading-normal flex-1 truncate">Shipping</p>
              <div class="shrink-0"><p class="text-[#161412] text-base font-normal leading-normal">KSH 5.00</p></div>
            </div>
            <div class="flex items-center gap-4 bg-white px-4 min-h-14 justify-between">
              <p class="text-[#161412] text-base font-normal leading-normal flex-1 truncate">Total</p>
              <div class="shrink-0"><p class="text-[#161412] text-base font-normal leading-normal">KSH 60.00</p></div>
            </div>
            <div class="flex px-4 py-3">
              <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-12 px-5 flex-1 bg-[#ebd7c5] text-[#161412] text-base font-bold leading-normal tracking-[0.015em]"
              >
                <span class="truncate">Place Order</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

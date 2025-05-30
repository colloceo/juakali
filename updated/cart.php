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
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#f5f2f0] px-10 py-3">
          <div class="flex items-center gap-8">
            <div class="flex items-center gap-4 text-[#181411]">
              <div class="size-4">
                <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 4H17.3334V17.3334H30.6666V30.6666H44V44H4V4Z" fill="currentColor"></path></svg>
              </div>
              <h2 class="text-[#181411] text-lg font-bold leading-tight tracking-[-0.015em]">Crafted Kenya</h2>
            </div>
            <div class="flex items-center gap-9">
              <a class="text-[#181411] text-sm font-medium leading-normal" href="#">Shop</a>
              <a class="text-[#181411] text-sm font-medium leading-normal" href="#">About</a>
              <a class="text-[#181411] text-sm font-medium leading-normal" href="#">Contact</a>
            </div>
          </div>
          <div class="flex flex-1 justify-end gap-8">
            <label class="flex flex-col min-w-40 !h-10 max-w-64">
              <div class="flex w-full flex-1 items-stretch rounded-xl h-full">
                <div
                  class="text-[#8a7460] flex border-none bg-[#f5f2f0] items-center justify-center pl-4 rounded-l-xl border-r-0"
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
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#181411] focus:outline-0 focus:ring-0 border-none bg-[#f5f2f0] focus:border-none h-full placeholder:text-[#8a7460] px-4 rounded-l-none border-l-0 pl-2 text-base font-normal leading-normal"
                  value=""
                />
              </div>
            </label>
            <button
              class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 bg-[#f5f2f0] text-[#181411] gap-2 text-sm font-bold leading-normal tracking-[0.015em] min-w-0 px-2.5"
            >
              <div class="text-[#181411]" data-icon="ShoppingCart" data-size="20px" data-weight="regular">
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
            <div class="flex flex-wrap justify-between gap-3 p-4"><p class="text-[#181411] tracking-light text-[32px] font-bold leading-tight min-w-72">Your Cart</p></div>
            <div class="px-4 py-3 @container">
              <div class="flex overflow-hidden rounded-xl border border-[#e6e0db] bg-white">
                <table class="flex-1">
                  <thead>
                    <tr class="bg-white">
                      <th class="table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-56 px-4 py-3 text-left text-[#181411] w-14 text-sm font-medium leading-normal">Product</th>
                      <th class="table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-176 px-4 py-3 text-left text-[#181411] w-[400px] text-sm font-medium leading-normal">Price</th>
                      <th class="table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-296 px-4 py-3 text-left text-[#181411] w-[400px] text-sm font-medium leading-normal">
                        Quantity
                      </th>
                      <th class="table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-416 px-4 py-3 text-left text-[#181411] w-[400px] text-sm font-medium leading-normal">
                        Subtotal
                      </th>
                      <th class="table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-536 px-4 py-3 text-left text-[#181411] w-60 text-[#8a7460] text-sm font-medium leading-normal">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-t border-t-[#e6e0db]">
                      <td class="table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-56 h-[72px] px-4 py-2 w-14 text-sm font-normal leading-normal">
                        <div
                          class="bg-center bg-no-repeat aspect-square bg-cover rounded-full w-10"
                          style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCobqonrR1-cL0KGFR-IsH93f36xwdQaGPh0WQAxWI2jsuoW9dc8QRrKqUe4RVtd-ZluF9knebk73DzvksTg6DaUEW0JOZbWvdjyc_TFumPePkY_2eRI9TtKQbkuM5vxj4Lf7dxkdo3AWPZqzGlLARx1IOGJBimWqgyamoBvMuqz_REXStHEV-fjcCtq85YrU0Urth1kYHGNAYCbHBjz9EEHqwqceEZBGCGI6iIClhto8zlKFrYPIUlxAAz5mq8Ht1yPaEGMMaYDp0");'
                        ></div>
                      </td>
                      <td class="table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-176 h-[72px] px-4 py-2 w-[400px] text-[#181411] text-sm font-normal leading-normal">
                        Ksh 1,500
                      </td>
                      <td class="table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-296 h-[72px] px-4 py-2 w-[400px] text-[#8a7460] text-sm font-normal leading-normal">2</td>
                      <td class="table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-416 h-[72px] px-4 py-2 w-[400px] text-[#8a7460] text-sm font-normal leading-normal">
                        Ksh 3,000
                      </td>
                      <td class="table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-536 h-[72px] px-4 py-2 w-60 text-[#8a7460] text-sm font-bold leading-normal tracking-[0.015em]">
                        Edit Quantity | Trash
                      </td>
                    </tr>
                    <tr class="border-t border-t-[#e6e0db]">
                      <td class="table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-56 h-[72px] px-4 py-2 w-14 text-sm font-normal leading-normal">
                        <div
                          class="bg-center bg-no-repeat aspect-square bg-cover rounded-full w-10"
                          style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBL5LGd8enuMIph3Qt-uA86vpmOlCql1f3_65ZZql-EwEivh4eub8xANC3HSqJQ8eBv5IGna8w4rH9OSzk3zKtRjxhclLbsGOO5I7QhOGWHZg5KCwpXpvAk5wgrpMvIJZuu-AsB1g8vBBXtvfCov5HlrAhGcHdgrvuf-503VlVsQfo18mZSg8TcEzSyVsR9SAQNBqpoDOItIbuJY4MYBB3hFNUFrxvMFwjNrgwSIp7ymdHZd596ELmupsCEP6CFMyda518Syy5oM-c");'
                        ></div>
                      </td>
                      <td class="table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-176 h-[72px] px-4 py-2 w-[400px] text-[#181411] text-sm font-normal leading-normal">Ksh 800</td>
                      <td class="table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-296 h-[72px] px-4 py-2 w-[400px] text-[#8a7460] text-sm font-normal leading-normal">1</td>
                      <td class="table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-416 h-[72px] px-4 py-2 w-[400px] text-[#8a7460] text-sm font-normal leading-normal">Ksh 800</td>
                      <td class="table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-536 h-[72px] px-4 py-2 w-60 text-[#8a7460] text-sm font-bold leading-normal tracking-[0.015em]">
                        Edit Quantity | Trash
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <style>
                          @container(max-width:56px){.table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-56{display: none;}}
                @container(max-width:176px){.table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-176{display: none;}}
                @container(max-width:296px){.table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-296{display: none;}}
                @container(max-width:416px){.table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-416{display: none;}}
                @container(max-width:536px){.table-d4d733a3-35a2-4ba2-87e5-808753375e74-column-536{display: none;}}
              </style>
            </div>
            <h3 class="text-[#181411] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Order Summary</h3>
            <div class="p-4">
              <div class="flex justify-between gap-x-6 py-2">
                <p class="text-[#8a7460] text-sm font-normal leading-normal">Subtotal</p>
                <p class="text-[#181411] text-sm font-normal leading-normal text-right">Ksh 3,800</p>
              </div>
              <div class="flex justify-between gap-x-6 py-2">
                <p class="text-[#8a7460] text-sm font-normal leading-normal">Shipping</p>
                <p class="text-[#181411] text-sm font-normal leading-normal text-right">Ksh 200</p>
              </div>
              <div class="flex justify-between gap-x-6 py-2">
                <p class="text-[#8a7460] text-sm font-normal leading-normal">Total</p>
                <p class="text-[#181411] text-sm font-normal leading-normal text-right">Ksh 4,000</p>
              </div>
            </div>
            <div class="flex px-4 py-3 justify-end">
              <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#f38220] text-[#181411] text-sm font-bold leading-normal tracking-[0.015em]"
              >
                <span class="truncate">Proceed to Checkout</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

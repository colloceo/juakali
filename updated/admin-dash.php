<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
    />

    <title>Stitch Design</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  </head>
  <body>
    <div class="relative flex size-full min-h-screen flex-col bg-white group/design-root overflow-x-hidden" style='font-family: Inter, "Noto Sans", sans-serif;'>
      <div class="layout-container flex h-full grow flex-col">
        <div class="gap-1 px-6 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col w-80">
            <div class="flex h-full min-h-[700px] flex-col justify-between bg-white p-4">
              <div class="flex flex-col gap-4">
                <div class="flex flex-col">
                  <h1 class="text-[#121416] text-base font-medium leading-normal">Admin Panel</h1>
                  <p class="text-[#6a7581] text-sm font-normal leading-normal">Manage your store</p>
                </div>
                <div class="flex flex-col gap-2">
                  <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-[#f1f2f4]">
                    <div class="text-[#121416]" data-icon="House" data-size="24px" data-weight="fill">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                        <path
                          d="M224,115.55V208a16,16,0,0,1-16,16H168a16,16,0,0,1-16-16V168a8,8,0,0,0-8-8H112a8,8,0,0,0-8,8v40a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V115.55a16,16,0,0,1,5.17-11.78l80-75.48.11-.11a16,16,0,0,1,21.53,0,1.14,1.14,0,0,0,.11.11l80,75.48A16,16,0,0,1,224,115.55Z"
                        ></path>
                      </svg>
                    </div>
                    <p class="text-[#121416] text-sm font-medium leading-normal">Dashboard</p>
                  </div>
                  <div class="flex items-center gap-3 px-3 py-2">
                    <div class="text-[#121416]" data-icon="Package" data-size="24px" data-weight="regular">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                        <path
                          d="M223.68,66.15,135.68,18a15.88,15.88,0,0,0-15.36,0l-88,48.17a16,16,0,0,0-8.32,14v95.64a16,16,0,0,0,8.32,14l88,48.17a15.88,15.88,0,0,0,15.36,0l88-48.17a16,16,0,0,0,8.32-14V80.18A16,16,0,0,0,223.68,66.15ZM128,32l80.34,44-29.77,16.3-80.35-44ZM128,120,47.66,76l33.9-18.56,80.34,44ZM40,90l80,43.78v85.79L40,175.82Zm176,85.78h0l-80,43.79V133.82l32-17.51V152a8,8,0,0,0,16,0V107.55L216,90v85.77Z"
                        ></path>
                      </svg>
                    </div>
                    <p class="text-[#121416] text-sm font-medium leading-normal">Products</p>
                  </div>
                  <div class="flex items-center gap-3 px-3 py-2">
                    <div class="text-[#121416]" data-icon="Receipt" data-size="24px" data-weight="regular">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                        <path
                          d="M72,104a8,8,0,0,1,8-8h96a8,8,0,0,1,0,16H80A8,8,0,0,1,72,104Zm8,40h96a8,8,0,0,0,0-16H80a8,8,0,0,0,0,16ZM232,56V208a8,8,0,0,1-11.58,7.15L192,200.94l-28.42,14.21a8,8,0,0,1-7.16,0L128,200.94,99.58,215.15a8,8,0,0,1-7.16,0L64,200.94,35.58,215.15A8,8,0,0,1,24,208V56A16,16,0,0,1,40,40H216A16,16,0,0,1,232,56Zm-16,0H40V195.06l20.42-10.22a8,8,0,0,1,7.16,0L96,199.06l28.42-14.22a8,8,0,0,1,7.16,0L160,199.06l28.42-14.22a8,8,0,0,1,7.16,0L216,195.06Z"
                        ></path>
                      </svg>
                    </div>
                    <p class="text-[#121416] text-sm font-medium leading-normal">Orders</p>
                  </div>
                  <div class="flex items-center gap-3 px-3 py-2">
                    <div class="text-[#121416]" data-icon="Users" data-size="24px" data-weight="regular">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                        <path
                          d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z"
                        ></path>
                      </svg>
                    </div>
                    <p class="text-[#121416] text-sm font-medium leading-normal">Users</p>
                  </div>
                  <div class="flex items-center gap-3 px-3 py-2">
                    <div class="text-[#121416]" data-icon="Gear" data-size="24px" data-weight="regular">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                        <path
                          d="M128,80a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Zm88-29.84q.06-2.16,0-4.32l14.92-18.64a8,8,0,0,0,1.48-7.06,107.21,107.21,0,0,0-10.88-26.25,8,8,0,0,0-6-3.93l-23.72-2.64q-1.48-1.56-3-3L186,40.54a8,8,0,0,0-3.94-6,107.71,107.71,0,0,0-26.25-10.87,8,8,0,0,0-7.06,1.49L130.16,40Q128,40,125.84,40L107.2,25.11a8,8,0,0,0-7.06-1.48A107.6,107.6,0,0,0,73.89,34.51a8,8,0,0,0-3.93,6L67.32,64.27q-1.56,1.49-3,3L40.54,70a8,8,0,0,0-6,3.94,107.71,107.71,0,0,0-10.87,26.25,8,8,0,0,0,1.49,7.06L40,125.84Q40,128,40,130.16L25.11,148.8a8,8,0,0,0-1.48,7.06,107.21,107.21,0,0,0,10.88,26.25,8,8,0,0,0,6,3.93l23.72,2.64q1.49,1.56,3,3L70,215.46a8,8,0,0,0,3.94,6,107.71,107.71,0,0,0,26.25,10.87,8,8,0,0,0,7.06-1.49L125.84,216q2.16.06,4.32,0l18.64,14.92a8,8,0,0,0,7.06,1.48,107.21,107.21,0,0,0,26.25-10.88,8,8,0,0,0,3.93-6l2.64-23.72q1.56-1.48,3-3L215.46,186a8,8,0,0,0,6-3.94,107.71,107.71,0,0,0,10.87-26.25,8,8,0,0,0-1.49-7.06Zm-16.1-6.5a73.93,73.93,0,0,1,0,8.68,8,8,0,0,0,1.74,5.48l14.19,17.73a91.57,91.57,0,0,1-6.23,15L187,173.11a8,8,0,0,0-5.1,2.64,74.11,74.11,0,0,1-6.14,6.14,8,8,0,0,0-2.64,5.1l-2.51,22.58a91.32,91.32,0,0,1-15,6.23l-17.74-14.19a8,8,0,0,0-5-1.75h-.48a73.93,73.93,0,0,1-8.68,0,8,8,0,0,0-5.48,1.74L100.45,215.8a91.57,91.57,0,0,1-15-6.23L82.89,187a8,8,0,0,0-2.64-5.1,74.11,74.11,0,0,1-6.14-6.14,8,8,0,0,0-5.1-2.64L46.43,170.6a91.32,91.32,0,0,1-6.23-15l14.19-17.74a8,8,0,0,0,1.74-5.48,73.93,73.93,0,0,1,0-8.68,8,8,0,0,0-1.74-5.48L40.2,100.45a91.57,91.57,0,0,1,6.23-15L69,82.89a8,8,0,0,0,5.1-2.64,74.11,74.11,0,0,1,6.14-6.14A8,8,0,0,0,82.89,69L85.4,46.43a91.32,91.32,0,0,1,15-6.23l17.74,14.19a8,8,0,0,0,5.48,1.74,73.93,73.93,0,0,1,8.68,0,8,8,0,0,0,5.48-1.74L155.55,40.2a91.57,91.57,0,0,1,15,6.23L173.11,69a8,8,0,0,0,2.64,5.1,74.11,74.11,0,0,1,6.14,6.14,8,8,0,0,0,5.1,2.64l22.58,2.51a91.32,91.32,0,0,1,6.23,15l-14.19,17.74A8,8,0,0,0,199.87,123.66Z"
                        ></path>
                      </svg>
                    </div>
                    <p class="text-[#121416] text-sm font-medium leading-normal">Settings</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4"><p class="text-[#121416] tracking-light text-[32px] font-bold leading-tight min-w-72">Dashboard Overview</p></div>
            <div class="flex flex-wrap gap-4 p-4">
              <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 bg-[#f1f2f4]">
                <p class="text-[#121416] text-base font-medium leading-normal">Total Sales</p>
                <p class="text-[#121416] tracking-light text-2xl font-bold leading-tight">KSH 3,450,000</p>
              </div>
              <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 bg-[#f1f2f4]">
                <p class="text-[#121416] text-base font-medium leading-normal">Orders Processed</p>
                <p class="text-[#121416] tracking-light text-2xl font-bold leading-tight">150</p>
              </div>
              <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 bg-[#f1f2f4]">
                <p class="text-[#121416] text-base font-medium leading-normal">Active Users</p>
                <p class="text-[#121416] tracking-light text-2xl font-bold leading-tight">75</p>
              </div>
            </div>
            <h2 class="text-[#121416] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Sales Statistics</h2>
            <div class="flex flex-wrap gap-4 px-4 py-6">
              <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-xl border border-[#dde0e3] p-6">
                <p class="text-[#121416] text-base font-medium leading-normal">Monthly Sales</p>
                <p class="text-[#121416] tracking-light text-[32px] font-bold leading-tight truncate">KSH 750,000</p>
                <div class="flex gap-1">
                  <p class="text-[#6a7581] text-base font-normal leading-normal">Last 6 Months</p>
                  <p class="text-[#07883b] text-base font-medium leading-normal">+15%</p>
                </div>
                <div class="flex min-h-[180px] flex-1 flex-col gap-8 py-4">
                  <svg width="100%" height="148" viewBox="-3 0 478 150" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path
                      d="M0 109C18.1538 109 18.1538 21 36.3077 21C54.4615 21 54.4615 41 72.6154 41C90.7692 41 90.7692 93 108.923 93C127.077 93 127.077 33 145.231 33C163.385 33 163.385 101 181.538 101C199.692 101 199.692 61 217.846 61C236 61 236 45 254.154 45C272.308 45 272.308 121 290.462 121C308.615 121 308.615 149 326.769 149C344.923 149 344.923 1 363.077 1C381.231 1 381.231 81 399.385 81C417.538 81 417.538 129 435.692 129C453.846 129 453.846 25 472 25V149H326.769H0V109Z"
                      fill="url(#paint0_linear_1131_5935)"
                    ></path>
                    <path
                      d="M0 109C18.1538 109 18.1538 21 36.3077 21C54.4615 21 54.4615 41 72.6154 41C90.7692 41 90.7692 93 108.923 93C127.077 93 127.077 33 145.231 33C163.385 33 163.385 101 181.538 101C199.692 101 199.692 61 217.846 61C236 61 236 45 254.154 45C272.308 45 272.308 121 290.462 121C308.615 121 308.615 149 326.769 149C344.923 149 344.923 1 363.077 1C381.231 1 381.231 81 399.385 81C417.538 81 417.538 129 435.692 129C453.846 129 453.846 25 472 25"
                      stroke="#6a7581"
                      stroke-width="3"
                      stroke-linecap="round"
                    ></path>
                    <defs>
                      <linearGradient id="paint0_linear_1131_5935" x1="236" y1="1" x2="236" y2="149" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#f1f2f4"></stop>
                        <stop offset="1" stop-color="#f1f2f4" stop-opacity="0"></stop>
                      </linearGradient>
                    </defs>
                  </svg>
                  <div class="flex justify-around">
                    <p class="text-[#6a7581] text-[13px] font-bold leading-normal tracking-[0.015em]">Jan</p>
                    <p class="text-[#6a7581] text-[13px] font-bold leading-normal tracking-[0.015em]">Feb</p>
                    <p class="text-[#6a7581] text-[13px] font-bold leading-normal tracking-[0.015em]">Mar</p>
                    <p class="text-[#6a7581] text-[13px] font-bold leading-normal tracking-[0.015em]">Apr</p>
                    <p class="text-[#6a7581] text-[13px] font-bold leading-normal tracking-[0.015em]">May</p>
                    <p class="text-[#6a7581] text-[13px] font-bold leading-normal tracking-[0.015em]">Jun</p>
                  </div>
                </div>
              </div>
            </div>
            <h2 class="text-[#121416] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Recent Orders</h2>
            <div class="px-4 py-3 @container">
              <div class="flex overflow-hidden rounded-xl border border-[#dde0e3] bg-white">
                <table class="flex-1">
                  <thead>
                    <tr class="bg-white">
                      <th class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-120 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                        Order ID
                      </th>
                      <th class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                        Customer
                      </th>
                      <th class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-360 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">Date</th>
                      <th class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-480 px-4 py-3 text-left text-[#121416] w-60 text-sm font-medium leading-normal">Status</th>
                      <th class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-600 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-t border-t-[#dde0e3]">
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">#1001</td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                        Aisha Hassan
                      </td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                        2024-07-20
                      </td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                        <button
                          class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#f1f2f4] text-[#121416] text-sm font-medium leading-normal w-full"
                        >
                          <span class="truncate">Shipped</span>
                        </button>
                      </td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-600 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                        KSH 22,500
                      </td>
                    </tr>
                    <tr class="border-t border-t-[#dde0e3]">
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">#1002</td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                        Jamal Mwangi
                      </td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                        2024-07-21
                      </td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                        <button
                          class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#f1f2f4] text-[#121416] text-sm font-medium leading-normal w-full"
                        >
                          <span class="truncate">Processing</span>
                        </button>
                      </td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-600 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                        KSH 30,000
                      </td>
                    </tr>
                    <tr class="border-t border-t-[#dde0e3]">
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">#1003</td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                        Fatima Ali
                      </td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                        2024-07-22
                      </td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                        <button
                          class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#f1f2f4] text-[#121416] text-sm font-medium leading-normal w-full"
                        >
                          <span class="truncate">Delivered</span>
                        </button>
                      </td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-600 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                        KSH 15,000
                      </td>
                    </tr>
                    <tr class="border-t border-t-[#dde0e3]">
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">#1004</td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                        David Kamau
                      </td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                        2024-07-23
                      </td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                        <button
                          class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#f1f2f4] text-[#121416] text-sm font-medium leading-normal w-full"
                        >
                          <span class="truncate">Shipped</span>
                        </button>
                      </td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-600 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                        KSH 45,000
                      </td>
                    </tr>
                    <tr class="border-t border-t-[#dde0e3]">
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">#1005</td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                        Grace Wambui
                      </td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                        2024-07-24
                      </td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                        <button
                          class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#f1f2f4] text-[#121416] text-sm font-medium leading-normal w-full"
                        >
                          <span class="truncate">Processing</span>
                        </button>
                      </td>
                      <td class="table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-600 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                        KSH 18,000
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <style>
                          @container(max-width:120px){.table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-120{display: none;}}
                @container(max-width:240px){.table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-240{display: none;}}
                @container(max-width:360px){.table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-360{display: none;}}
                @container(max-width:480px){.table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-480{display: none;}}
                @container(max-width:600px){.table-9f06b6d0-a163-4711-8b1c-c7d2ea0b28ed-column-600{display: none;}}
              </style>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

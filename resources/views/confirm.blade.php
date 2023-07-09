<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body>
    <div class="flex justify-center items-start rounded-md h-screen w-full bg-slate-50">

        <div class="w-full h-full max-w-xl py-0 px-8">
            <div class=" bg-white flex gap-y-8 pt-16 flex-col justify-between items-center w-full h-full shadow-md">
                <div class="flex justify-center items-center w-full text-center text-3xl font-bold">
                    <img class="w-52" src="http://127.0.0.1:5173/img/logo.svg" alt="">
                </div>

                <div class="flex justify-center  items-center flex-col text-[#2D565E]  gap-y-8">
                    <div class="flex flex-col gap-y-4 px-4">
                        <div class="leading-normal">
                            <p class="font-bold">Hola {{$contact['name']}},</p>
                            <p>Te damos la bienvenida a LienzoMania.</p>
                        </div>
                        <div class="text-center text-sm">
                            <p>Para terminar el proceso de validación, da click en
                                <span class="text-[#E35544]">Confirmación de cuenta.</span>
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex font-bold justify-center text-center w-fit items-center gap-x-2 py-1 px-4 shadow-sm  cursor-pointer text-white font-quicksand-bold rounded-md bg-gradient-to-r from-[#E35544] to-[#be2b1b] border-2 border-[#E35544]">
                        Confirmación de cuenta
                    </div>
                </div>
                <a class="flex py-1 gap-x-2 justify-center items-center w-full text-[#2D565E]"
                    href="https://www.lienzomaniaec.com/">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.115 5.19l.319 1.913A6 6 0 008.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 002.288-4.042 1.087 1.087 0 00-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 01-.98-.314l-.295-.295a1.125 1.125 0 010-1.591l.13-.132a1.125 1.125 0 011.3-.21l.603.302a.809.809 0 001.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 001.528-1.732l.146-.292M6.115 5.19A9 9 0 1017.18 4.64M6.115 5.19A8.965 8.965 0 0112 3c1.929 0 3.716.607 5.18 1.64" />
                    </svg>



                    <span class="font-bold">www.linezomaniaec.com</span>
                </a>
            </div>

        </div>
    </div>
</body>

</html>
@extends('layouts.client') 
@section('title', 'Liên hệ')

@section('content')
<div class="max-w-4xl mx-auto">

  
    <div class="mb-4">
    <a href="{{ route('home') }}"
       class="text-blue-600 hover:underline flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Quay lại trang chủ
    </a>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">

        <h2 class="text-2xl font-bold mb-6 text-gray-800">
            Gửi thông tin liên hệ
        </h2>

        @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 font-semibold">
        {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

               
                <div class="col-span-2">
                    <label class="block font-semibold mb-2 text-gray-700">
                        Họ tên
                    </label>
                    <input type="text"
                           name="ho_ten"
                           value="{{ old('ho_ten') }}"
                           required
                           class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none
                                  @error('ho_ten') border-red-500 @enderror"
                           placeholder="Nhập họ tên của bạn">
                    @error('ho_ten')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block font-semibold mb-2 text-gray-700">
                        Email
                    </label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none
                                  @error('email') border-red-500 @enderror"
                           placeholder="email@example.com">
                    @error('email')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2">
                    <label class="block font-semibold mb-2 text-gray-700">
                        Nội dung liên hệ
                    </label>
                    <textarea name="noi_dung"
                              rows="5"
                              required
                              class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none
                                     @error('noi_dung') border-red-500 @enderror"
                              placeholder="Nhập nội dung bạn muốn liên hệ...">{{ old('noi_dung') }}</textarea>
                    @error('noi_dung')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            
            <div class="mt-8 border-t pt-6">
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold
                               hover:bg-blue-700 shadow-lg transition-all
                               flex justify-center items-center uppercase tracking-widest">
                    <i class="fas fa-paper-plane mr-2"></i> Gửi liên hệ
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

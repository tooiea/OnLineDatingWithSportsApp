import React from "react";
import { Link } from '@inertiajs/react';

export default function Error403() {
  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-100 to-green-100 flex flex-col justify-center items-center px-4">
      <p className="text-xl text-gray-800 mb-2">403. アクセスが拒否されました。</p>
      <Link href="/" className="text-blue-600 hover:underline">ホームに戻る</Link>
      <div className="mt-10 text-m text-gray-500">OnLine Dating With Sports</div>
    </div>
  );
}

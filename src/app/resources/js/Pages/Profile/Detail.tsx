import { Head, Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Pencil } from 'lucide-react';
import { useEffect, useState } from 'react';

interface Props {
  nickname: string;
  positionLabel: string | null;
  handednessLabel: string | null;
  imagePath: string | null;
  message?: {
    success?: string;
  };
}

export default function MyProfileShow({
  nickname,
  positionLabel,
  handednessLabel,
  imagePath,
  message,
}: Props) {
  const [visibleMessage, setVisibleMessage] = useState<string | null>(message?.success ?? null);

  useEffect(() => {
    if (message?.success) {
      const timer = setTimeout(() => setVisibleMessage(null), 3000);
      return () => clearTimeout(timer);
    }
  }, [message]);

  return (
    <AuthenticatedLayout>
      <Head title="マイプロフィール" />
      <div className="max-w-4xl mx-auto py-10 px-4">
        {visibleMessage && (
          <div className="mb-6 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-md shadow-sm transition-opacity duration-500 ease-in-out">
            {visibleMessage}
          </div>
        )}

        <div className="bg-white shadow rounded-lg p-6">
          <h1 className="text-xl font-bold text-gray-800 mb-6">マイプロフィール</h1>

          <div className="flex flex-col md:flex-row items-start gap-6">
            <div className="flex justify-center md:block md:w-1/3">
              {imagePath ? (
                <img
                  src={imagePath}
                  alt="プロフィール画像"
                  className="w-40 h-40 object-cover border rounded"
                />
              ) : (
                <div className="w-40 h-40 bg-gray-100 border rounded flex items-center justify-center text-gray-400">
                  No Image
                </div>
              )}
            </div>

            <div className="flex-1 space-y-4">
              <div>
                <p className="text-sm font-semibold text-gray-600">ニックネーム</p>
                <div className="flex items-center gap-2">
                  <p className="text-gray-800">{nickname}</p>
                  <Link href={route('my-profile.edit')} className="text-indigo-500 hover:text-indigo-700">
                    <Pencil size={16} />
                  </Link>
                </div>
              </div>

              <div>
                <p className="text-sm font-semibold text-gray-600">ポジション</p>
                <p className="text-gray-800">{positionLabel ?? '未設定'}</p>
              </div>

              <div>
                <p className="text-sm font-semibold text-gray-600">利き手</p>
                <p className="text-gray-800">{handednessLabel ?? '未設定'}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}

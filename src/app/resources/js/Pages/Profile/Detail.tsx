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
  routes: {
    edit: string;
  };
}

export default function MyProfileShow({
  nickname,
  positionLabel,
  handednessLabel,
  imagePath,
  message,
  routes,
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

        <div className="bg-white shadow-lg rounded-xl p-6 md:p-8">
          <h3 className="text-xl font-bold border-b pb-3 mb-6">マイプロフィール</h3>

          <div className="grid grid-cols-1 gap-4">
            {imagePath ? (
              <div className="w-full flex justify-center">
                <img
                  src={imagePath}
                  alt="プロフィール画像"
                  className="w-40 h-40 object-cover rounded-lg border"
                />
              </div>
            ) : (
              <div className="w-full flex justify-center">
                <div className="w-40 h-40 bg-gray-100 border rounded flex items-center justify-center text-gray-400">
                  No Image
                </div>
              </div>
            )}

            <div className="space-y-4 text-sm text-gray-800">
              <div className="border-t pt-4">
                <div className="text-xs text-gray-500">ニックネーム</div>
                <div className="flex items-center gap-2">
                  <div className="font-medium">{nickname}</div>
                  <Link href={routes.edit} className="text-indigo-500 hover:text-indigo-700">
                    <Pencil size={16} />
                  </Link>
                </div>
              </div>
              <div className="border-t pt-4">
                <div className="text-xs text-gray-500">ポジション</div>
                <div className="font-medium">{positionLabel ?? '未設定'}</div>
              </div>
              <div className="border-t pt-4">
                <div className="text-xs text-gray-500">利き手</div>
                <div className="font-medium">{handednessLabel ?? '未設定'}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}

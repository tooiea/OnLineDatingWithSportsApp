import { useForm, router } from '@inertiajs/react';
import { useRef, useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import LabelBlock from '@/Components/LabelBlock';

interface Option {
  value: number;
  label: string;
}

interface Props {
  positionOptions: Option[];
  handednessOptions: Option[];
  userProfile: {
    nickname: string;
    position: number | null;
    handedness: number | null;
    image_path: string | null;
  };
  routes: {
    update: string;
  }
}

export default function ProfileEdit({
  positionOptions,
  handednessOptions,
  userProfile,
  routes,
}: Props) {
  interface FormData {
    [key: string]: string | number | boolean | File | null;
    nickname: string;
    position: number | null;
    handedness: number | null;
    image: File | null;
    deleteImage: boolean;
  }

  const { data, setData, processing, errors } = useForm<FormData>({
    nickname: userProfile.nickname || '',
    position: userProfile.position ?? null,
    handedness: userProfile.handedness ?? null,
    image: null,
    deleteImage: false,
  });

  const imageInputRef = useRef<HTMLInputElement | null>(null);
  const [previewImage, setPreviewImage] = useState<string | null>(userProfile.image_path || null);

  const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      setData('image', file);
      setData('deleteImage', true); // 新しい画像がある場合も削除フラグをtrueに
      const reader = new FileReader();
      reader.onloadend = () => setPreviewImage(reader.result as string);
      reader.readAsDataURL(file);
    }
  };

  const handleImageDelete = () => {
    setPreviewImage(null);
    setData('image', null);
    setData('deleteImage', true);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    const formData = new FormData();
    formData.append('nickname', data.nickname);
    formData.append('position', data.position !== null ? String(data.position) : '');
    formData.append('handedness', data.handedness !== null ? String(data.handedness) : '');
    formData.append('deleteImage', data.deleteImage ? '1' : '0');
    if (data.image instanceof File) {
      formData.append('image', data.image);
    }

    router.post(routes.update, formData, {
      forceFormData: true,
    });
  };

  return (
    <AuthenticatedLayout>
      <Head title="マイプロフィール編集" />
      <div className="max-w-3xl mx-auto py-10 px-4">
        <form
          onSubmit={handleSubmit}
          encType="multipart/form-data"
          className="bg-white shadow rounded-lg p-6 space-y-6"
        >
          <h1 className="text-xl font-bold text-gray-800 border-b pb-2">
            マイプロフィール編集
          </h1>

          <div>
            <LabelBlock label='ニックネーム' required>
              <input
                type="text"
                value={data.nickname}
                onChange={(e) => setData('nickname', e.target.value)}
                className="w-full border rounded px-3 py-2"
              />
            </LabelBlock>
            {errors.nickname && (
              <p className="text-sm text-red-500 mt-1">{errors.nickname}</p>
            )}
          </div>

          <div>
            <LabelBlock label='ポジション'>
              <select
                value={data.position ?? ''}
                onChange={(e) =>
                  setData('position', e.target.value === '' ? null : Number(e.target.value))
                }
                className="w-full border rounded px-3 py-2"
              >
                <option value="">選択してください</option>
                {positionOptions.map((p) => (
                  <option key={p.value} value={p.value}>
                    {p.label}
                  </option>
                ))}
              </select>
            </LabelBlock>
            {errors.position && (
              <p className="text-sm text-red-500 mt-1">{errors.position}</p>
            )}
          </div>

          <div>
            <LabelBlock label='利き手'>
              <select
                value={data.handedness ?? ''}
                onChange={(e) =>
                  setData('handedness', e.target.value === '' ? null : Number(e.target.value))
                }
                className="w-full border rounded px-3 py-2"
              >
                <option value="">選択してください</option>
                {handednessOptions.map((h) => (
                  <option key={h.value} value={h.value}>
                    {h.label}
                  </option>
                ))}
              </select>
            </LabelBlock>
            {errors.handedness && (
              <p className="text-sm text-red-500 mt-1">{errors.handedness}</p>
            )}
          </div>

          <div>
            <LabelBlock label='プロフィール画像' description='PNG、JPG、JPEG形式の拡張子' >
              {previewImage && (
                <div className="mb-2">
                  <img
                    src={previewImage}
                    alt="プロフィール画像"
                    className="w-32 h-32 object-contain border rounded mb-2"
                  />
                  <button
                    type="button"
                    onClick={handleImageDelete}
                    className="text-sm text-red-600 hover:underline"
                  >
                    画像を削除
                  </button>
                </div>
              )}
              <input
                type="file"
                ref={imageInputRef}
                accept="image/*"
                onChange={handleImageChange}
                className="w-full"
              />
            </LabelBlock>
            {errors.image && (
              <p className="text-sm text-red-500 mt-1">{errors.image}</p>
            )}
          </div>

          <div className="text-center">
            <button
              type="submit"
              className="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700"
              disabled={processing}
            >
              保存
            </button>
          </div>
        </form>
      </div>
    </AuthenticatedLayout>
  );
}

import { FormDataConvertible } from '@inertiajs/inertia';
import { Head, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { PageProps } from '@/types';
import React, { useRef, useState } from 'react';

interface TeamImage {
  id: number;
  path_base64: string;
  extension: string;
  mime_type: string;
}

interface Team {
  id: string;
  name: string;
  team_url?: string | null;
  image?: TeamImage | null;
}

interface AlbumImage {
  id: number;
  path_base64: string;
  extension: string;
  mime_type: string;
}

interface Props extends PageProps {
  team: Team;
  albumImages: AlbumImage[];
}

interface FormDataType {
  [key: string]: FormDataConvertible;
  teamName: string;
  teamUrl: string;
  imagePath: File | null;
  teamAlbum: File[];
  deleteAlbum: string[];
}

export default function TeamEdit({ auth, team, albumImages }: Props) {
  const [previewImage, setPreviewImage] = useState<string | null>(null);
  const imageInputRef = useRef<HTMLInputElement | null>(null);

  const {
    data,
    setData,
    post,
    processing,
    errors,
  } = useForm<FormDataType>({
    teamName: team.name || '',
    teamUrl: team.team_url || '',
    imagePath: null,
    teamAlbum: [],
    deleteAlbum: [],
  });

  const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      setData('imagePath', file);
      const reader = new FileReader();
      reader.onloadend = () => {
        setPreviewImage(reader.result as string);
      };
      reader.readAsDataURL(file);
    }
  };

  const handleAlbumChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const files = Array.from(e.target.files || []);
    setData('teamAlbum', files);
  };

  const handleAlbumDeleteToggle = (id: number) => {
    const idStr = String(id);
    setData('deleteAlbum', data.deleteAlbum.includes(idStr)
      ? data.deleteAlbum.filter(i => i !== idStr)
      : [...data.deleteAlbum, idStr]);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('myteam.update'), {
      forceFormData: true,
    });
  };

  return (
    <AuthenticatedLayout>
      <Head title="チームプロフィール編集" />
      <div className="max-w-4xl mx-auto py-10 px-4">
        <div className="bg-white shadow-md rounded-lg p-6">
          <h1 className="text-2xl font-semibold mb-6 text-center">チームプロフィール編集</h1>
          <form onSubmit={handleSubmit} encType="multipart/form-data" className="space-y-6">
            <div>
              <label htmlFor="teamName" className="block font-semibold mb-1">チーム名</label>
              <input
                type="text"
                id="teamName"
                value={data.teamName}
                onChange={(e) => setData('teamName', e.target.value)}
                className="w-full border rounded-md px-3 py-2"
              />
              {errors.teamName && <p className="text-sm text-red-500 mt-1">{errors.teamName}</p>}
            </div>

            <div>
              <label htmlFor="imagePath" className="block font-semibold mb-1">チームロゴ画像</label>
              {previewImage ? (
                <img src={previewImage} className="w-32 h-32 object-contain mb-2 rounded" alt="preview" />
              ) : team.image?.path_base64 ? (
                <img src={team.image.path_base64} className="w-32 h-32 object-contain mb-2 rounded" alt="logo" />
              ) : null}
              <input
                type="file"
                id="imagePath"
                ref={imageInputRef}
                onChange={handleImageChange}
                className="w-full"
              />
              {errors.imagePath && <p className="text-sm text-red-500 mt-1">{errors.imagePath}</p>}
            </div>

            <div>
              <label htmlFor="teamUrl" className="block font-semibold mb-1">チーム紹介URL</label>
              <input
                type="text"
                id="teamUrl"
                value={data.teamUrl}
                onChange={(e) => setData('teamUrl', e.target.value)}
                className="w-full border rounded-md px-3 py-2"
              />
              {errors.teamUrl && <p className="text-sm text-red-500 mt-1">{errors.teamUrl}</p>}
            </div>

            <div>
              <label className="block font-semibold mb-1">登録済みアルバム画像（削除可）</label>
              <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                {albumImages.map((img) => (
                  <div key={img.id} className="relative">
                    <img src={img.path_base64} className="w-full h-24 object-cover rounded" alt="album" />
                    <input
                      type="checkbox"
                      className="absolute top-1 right-1"
                      onChange={() => handleAlbumDeleteToggle(img.id)}
                      checked={data.deleteAlbum.includes(String(img.id))}
                    />
                  </div>
                ))}
              </div>
            </div>

            <div>
              <label htmlFor="teamAlbum" className="block font-semibold mb-1">アルバム画像を追加（最大5枚）</label>
              <input
                type="file"
                id="teamAlbum"
                multiple
                onChange={handleAlbumChange}
                className="w-full"
              />
              {errors.teamAlbum && <p className="text-sm text-red-500 mt-1">{errors.teamAlbum}</p>}
            </div>

            <div className="text-center">
              <button
                type="submit"
                className="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700"
                disabled={processing}
              >
                更新する
              </button>
            </div>
          </form>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}

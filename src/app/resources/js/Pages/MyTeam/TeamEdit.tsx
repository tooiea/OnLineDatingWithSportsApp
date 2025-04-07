import { Head, router, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { PageProps } from '@/types';
import React, { useRef, useState } from 'react';
import { v4 as uuidv4 } from 'uuid';

interface TeamImage {
  id: number;
  path_base64: string;
  extension: string;
  mime_type: string;
}

interface AlbumImage {
  id: number;
  path_base64: string;
  extension: string;
  mime_type: string;
}

interface Album {
  id: string;
  name: string;
  images: AlbumImage[];
}

interface Team {
  id: string;
  name: string;
  team_url?: string | null;
  image?: TeamImage | null;
  prefecture?: string;
  address?: string;
  favoriteFacility?: string;
}

interface Prefecture {
  value: number;
  label: string;
}

interface Props extends PageProps {
  team: Team;
  albums: Album[];
  prefectures: Prefecture[];
}

interface FormDataType {
  teamName: string;
  teamUrl: string;
  prefecture: number;
  address: string;
  favoriteFacility: string;
  teamMainImage: File | null;
  [key: string]: any;
}

export default function TeamEdit({ auth, team, albums, prefectures }: Props) {
  const [previewImage, setPreviewImage] = useState<string | null>(null);
  const imageInputRef = useRef<HTMLInputElement | null>(null);

  const [albumData, setAlbumData] = useState<Record<string, {
    name: string;
    newImages: File[];
    deleteImageIds: string[];
    expanded: boolean;
    isNew: boolean;
    isDelete?: boolean;
    existingImages?: AlbumImage[];
  }>>(() => {
    const initial: Record<string, any> = {};
    albums.forEach((album) => {
      initial[album.id] = {
        name: album.name,
        newImages: [],
        deleteImageIds: [],
        expanded: false,
        isNew: false,
        existingImages: album.images || [],
        isDelete: false,
      };
    });
    return initial;
  });

  const { data, setData, processing, errors, setError } = useForm<FormDataType>({
    teamName: team.name || '',
    teamUrl: team.team_url || '',
    prefecture: team.prefecture ? Number(team.prefecture) : 0,
    address: team.address || '',
    favoriteFacility: team.favoriteFacility || '',
    teamMainImage: null,
  });

  const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      setData('teamMainImage', file);
      const reader = new FileReader();
      reader.onloadend = () => setPreviewImage(reader.result as string);
      reader.readAsDataURL(file);
    }
  };

  const toggleAlbumExpand = (albumId: string) => {
    setAlbumData((prev) => ({
      ...prev,
      [albumId]: {
        ...prev[albumId],
        expanded: !prev[albumId].expanded,
      },
    }));
  };

  const handleNewImages = (albumId: string, files: File[]) => {
    setAlbumData((prev) => ({
      ...prev,
      [albumId]: {
        ...prev[albumId],
        newImages: files,
      },
    }));
  };

  const toggleDeleteImage = (albumId: string, imageId: number) => {
    setAlbumData((prev) => {
      const current = prev[albumId].deleteImageIds;
      return {
        ...prev,
        [albumId]: {
          ...prev[albumId],
          deleteImageIds: current.includes(String(imageId))
            ? current.filter((id) => id !== String(imageId))
            : [...current, String(imageId)],
        },
      };
    });
  };

  const toggleDeleteAlbum = (albumId: string) => {
    setAlbumData((prev) => ({
      ...prev,
      [albumId]: {
        ...prev[albumId],
        isDelete: !prev[albumId].isDelete,
      },
    }));
  };

  const addNewAlbum = () => {
    const newId = uuidv4();
    setAlbumData((prev) => ({
      ...prev,
      [newId]: {
        name: '',
        newImages: [],
        deleteImageIds: [],
        expanded: true,
        isNew: true,
        isDelete: false,
      },
    }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    const formData = new FormData();

    Object.entries(data).forEach(([key, value]) => {
      if (key === 'teamMainImage') {
        if (value instanceof File) {
          formData.append('teamMainImage', value);
        }
      } else {
        formData.append(key, String(value ?? ''));
      }
    });

    let albumIndex = 0;
    Object.entries(albumData).forEach(([albumId, album]) => {
      formData.append(`albums[${albumIndex}][id]`, albumId);
      formData.append(`albums[${albumIndex}][name]`, album.name);
      formData.append(`albums[${albumIndex}][isDelete]`, album.isDelete ? '1' : '0');
      album.newImages.forEach((img) => {
        formData.append(`albums[${albumIndex}][addImages][]`, img);
      });
      album.deleteImageIds.forEach((id) => {
        formData.append(`albums[${albumIndex}][deleteImages][]`, id);
      });
      albumIndex++;
    });

    router.post(route('myteam.update'), formData, {
      forceFormData: true,
      onError: (errors) => {
        Object.entries(errors).forEach(([key, message]) => {
          setError(key as keyof FormDataType, message);
        });
      },
    });
  };

  return (
    <AuthenticatedLayout>
      <Head title="チームプロフィール編集" />
      <div className="max-w-4xl mx-auto py-10 px-4">
        <form onSubmit={handleSubmit} encType="multipart/form-data" className="space-y-6">
          <h1 className="text-2xl font-semibold text-center">チームプロフィール編集</h1>

          {/* チーム情報 */}
          <div>
            <label className="block font-semibold">チーム名</label>
            <input type="text" value={data.teamName} onChange={(e) => setData('teamName', e.target.value)} className="w-full border rounded px-3 py-2" />
            {errors.teamName && <p className="text-sm text-red-500">{errors.teamName}</p>}
          </div>

          <div>
            <label className="block font-semibold">都道府県</label>
            <select value={data.prefecture} onChange={(e) => setData('prefecture', Number(e.target.value))} className="w-full border rounded px-3 py-2">
              <option value={0}>選択してください</option>
              {prefectures.map((pref) => (
                <option key={pref.value} value={pref.value}>{pref.label}</option>
              ))}
            </select>
            {errors.prefecture && <p className="text-sm text-red-500">{errors.prefecture}</p>}
          </div>

          <div>
            <label className="block font-semibold">住所</label>
            <input type="text" value={data.address} onChange={(e) => setData('address', e.target.value)} className="w-full border rounded px-3 py-2" />
            {errors.address && <p className="text-sm text-red-500">{errors.address}</p>}
          </div>

          <div>
            <label className="block font-semibold">よく使う施設名</label>
            <input type="text" value={data.favoriteFacility} onChange={(e) => setData('favoriteFacility', e.target.value)} className="w-full border rounded px-3 py-2" />
            {errors.favoriteFacility && <p className="text-sm text-red-500">{errors.favoriteFacility}</p>}
          </div>

          <div>
            <label className="block font-semibold">チーム紹介URL</label>
            <input type="text" value={data.teamUrl} onChange={(e) => setData('teamUrl', e.target.value)} className="w-full border rounded px-3 py-2" />
            {errors.teamUrl && <p className="text-sm text-red-500">{errors.teamUrl}</p>}
          </div>

          <div>
            <label className="block font-semibold">チームロゴ画像</label>
            {previewImage ? <img src={previewImage} className="w-32 h-32 object-contain mb-2" /> : team.image?.path_base64 && <img src={team.image.path_base64} className="w-32 h-32 object-contain mb-2" />}
            <input type="file" ref={imageInputRef} onChange={handleImageChange} className="w-full" />
            {errors.teamMainImage && <p className="text-sm text-red-500">{errors.teamMainImage}</p>}
          </div>

          {/* アルバム表示 */}
          <div>
            <h2 className="text-lg font-bold mb-2">アルバム</h2>
            <button type="button" onClick={addNewAlbum} className="mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">＋ アルバム追加</button>
            {Object.entries(albumData).map(([albumId, album], index) => (
              <div key={albumId} className={`border p-4 rounded-md shadow-sm mb-4 ${album.isDelete ? 'bg-red-100' : ''}`}>
                <div className="flex justify-between items-center">
                  <div className="flex items-center space-x-2">
                    <h3 className="font-semibold">{album.name || '新規アルバム'}</h3>
                    {album.isDelete && <span className="text-red-600 text-xs">（削除予定）</span>}
                  </div>
                  <div className="flex gap-2">
                    <button type="button" onClick={() => toggleAlbumExpand(albumId)} className="text-sm text-blue-600">{album.expanded ? '閉じる' : '編集'}</button>
                    {!album.isNew && (
                      <button type="button" onClick={() => toggleDeleteAlbum(albumId)} className="text-sm text-red-500">
                        {album.isDelete ? '削除を取消' : '削除'}
                      </button>
                    )}
                  </div>
                </div>

                {album.expanded && !album.isDelete && (
                  <div className="mt-4 space-y-4">
                    <input
                      type="text"
                      placeholder="アルバム名"
                      value={album.name}
                      onChange={(e) => setAlbumData((prev) => ({
                        ...prev,
                        [albumId]: {
                          ...prev[albumId],
                          name: e.target.value,
                        },
                      }))}
                      className="w-full border rounded px-2 py-1"
                    />
                    {errors[`albums.${index}.name`] && <p className="text-sm text-red-500">{errors[`albums.${index}.name`]}</p>}
                    {errors[`albums.${index}`] && <p className="text-sm text-red-500">{errors[`albums.${index}`]}</p>}

                    {(album.existingImages ?? []).length > 0 && (
                      <div className="grid grid-cols-5 gap-2">
                        {(album.existingImages ?? []).map((img) => (
                          <div key={img.id} className="relative">
                            <img src={img.path_base64} className="w-full h-full object-cover rounded" />
                            <input
                              type="checkbox"
                              className="absolute top-1 right-1"
                              checked={album.deleteImageIds.includes(String(img.id))}
                              onChange={() => toggleDeleteImage(albumId, img.id)}
                            />
                          </div>
                        ))}
                      </div>
                    )}

                    <input
                      type="file"
                      multiple
                      onChange={(e) => handleNewImages(albumId, Array.from(e.target.files || []))}
                      className="w-full"
                    />
                    {errors[`albums.${index}.addImages.0`] && <p className="text-sm text-red-500">{errors[`albums.${index}.addImages.0`]}</p>}
                  </div>
                )}
              </div>
            ))}
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
    </AuthenticatedLayout>
  );
}

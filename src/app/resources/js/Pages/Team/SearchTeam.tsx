import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, router } from '@inertiajs/react';
import { PageProps } from '@/types';

interface Prefecture {
    value: number;
    label: string;
}

interface Team {
    id: number;
    name: string;
    code: string;
    logo?: string;
    extension?: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props extends Record<string, unknown> {
    prefectures: Prefecture[];
    teams: { data: Team[]; links: PaginationLink[] };
    filters: { prefecture?: number; address?: string };
    myTeam?: any;
}

export default function SearchTeam({ auth, teams, filters, prefectures, myTeam }: PageProps<Props>) {
    const [prefecture, setPrefecture] = React.useState(filters.prefecture || '');
    const [address, setAddress] = React.useState(filters.address || '');

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        router.get(route('team.list'), { prefecture, address });
    };

    return (
        <AuthenticatedLayout>
            <Head title="招待チームを検索" />

            <div className="max-w-5xl mx-auto px-6 py-10">
                <div className="bg-white shadow-md rounded-xl p-8">
                    <h2 className="text-xl font-semibold mb-4 border-b pb-2">招待チームを検索</h2>
                    <form onSubmit={submit} className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label className="block mb-1 text-sm font-medium">都道府県</label>
                            <select
                                value={prefecture}
                                onChange={(e) => setPrefecture(e.target.value)}
                                className="block w-full border-gray-300 rounded-md shadow-sm"
                            >
                                <option value="">選択してください</option>
                                {prefectures.map((pref) => (
                                    <option key={pref.value} value={pref.value}>{pref.label}</option>
                                ))}
                            </select>
                        </div>

                        <div>
                            <label className="block mb-1 text-sm font-medium">住所（市町村区）</label>
                            <input
                                type="text"
                                value={address}
                                onChange={(e) => setAddress(e.target.value)}
                                className="block w-full border-gray-300 rounded-md shadow-sm"
                            />
                        </div>

                        <button type="submit" className="col-span-full bg-indigo-500 hover:bg-indigo-600 text-white rounded-md py-2 font-semibold">
                            検索する
                        </button>
                    </form>

                    <div className="mt-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        {teams.data.length > 0 ? (
                            teams.data.map((team) => (
                                <div key={team.id} className="bg-white border rounded-lg shadow-sm hover:shadow-lg transition p-4 flex flex-col items-center">
                                    {team.logo && (
                                        <img src={team.logo} className="w-16 h-16 rounded-full object-cover mb-3" alt="team logo" />
                                    )}
                                    <div className="text-center font-semibold mb-2">{team.name}</div>
                                    <Link href={route('team.invite_game', team.id)} className="text-indigo-500 hover:underline">
                                        招待する
                                    </Link>
                                </div>
                            ))
                        ) : (
                            <div className="col-span-full text-center text-gray-600">該当するチームが登録されていません。</div>
                        )}
                    </div>

                    {teams.links && (
                        <div className="mt-6 flex justify-center gap-1 flex-wrap text-sm">
                            {teams.links.filter(link => link.url !== null).map((link, index) => (
                                <span
                                    key={index}
                                    className={`px-2 py-1 rounded-md border ${link.active ? 'bg-indigo-500 text-white' : 'bg-white text-gray-700 hover:bg-indigo-200'}`}
                                >
                                    {link.active ? (
                                        <span dangerouslySetInnerHTML={{ __html: link.label }} />
                                    ) : (
                                        <Link href={link.url || '#'} dangerouslySetInnerHTML={{ __html: link.label }} />
                                    )}
                                </span>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

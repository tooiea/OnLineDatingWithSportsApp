import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, router } from '@inertiajs/react';
import { PageProps } from '@/types';
import dayjs from 'dayjs';
import 'dayjs/locale/ja';

import duration from 'dayjs/plugin/duration';
dayjs.extend(duration);
dayjs.locale('ja');

interface Team {
  id: string;
  name: string;
  image?: {
    path_base64: string;
  };
}

interface InviteData {
  id: string;
  created_at: string;
  consent_status: number;
  first_preferered_date: string;
  second_preferered_date?: string;
  third_preferered_date?: string;
  unread?: boolean;
  team: Team;
  game_date?: string | null;
}

interface Props extends PageProps {
  myTeam: Team | null;
  myTeamInvites: InviteData[];
  asGuestInvites: InviteData[];
  inviteStatuses: Record<number, string>;
}

const formatFullDate = (date?: string) =>
  date ? dayjs(date).format('YYYY年MM月DD日（ddd）') : 'ー';

const formatTime = (date?: string) =>
  date ? `${dayjs(date).format('HH:mm')}～` : 'ー';

const renderDate = (label: string, date?: string, highlightDate?: string) => {
  const isPast = date ? dayjs(date).isBefore(dayjs()) : false;
  const isHighlight = highlightDate && date && dayjs(date).isSame(highlightDate, 'day');
  const faded = highlightDate && date && !dayjs(date).isSame(highlightDate, 'day');

  return (
    <li className="flex items-center gap-2">
      <span className="font-semibold">{label}</span>
      <span
        className={`$${isPast ? 'line-through text-gray-400' : ''} ${faded ? 'text-gray-400' : ''} ${isHighlight ? 'font-bold text-blue-700' : ''}`.trim()}
      >
        {formatFullDate(date)} {formatTime(date)}
      </span>
    </li>
  );
};

const getLatestDate = (
  first?: string,
  second?: string,
  third?: string
): dayjs.Dayjs | null => {
  const dates = [first, second, third]
    .filter((d): d is string => !!d)
    .map((d) => dayjs(d))
    .sort((a, b) => b.valueOf() - a.valueOf());

  return dates.length > 0 ? dates[0] : null;
};

const getDeadlineLabel = (
  first?: string,
  second?: string,
  third?: string
): string | null => {
  const latestDate = getLatestDate(first, second, third);
  if (!latestDate) return null;

  const deadline = latestDate.subtract(7, 'day');
  const daysLeft = deadline.diff(dayjs(), 'day');

  if (daysLeft === 7) return `⏰ 返事期限まであと7日`;
  if (daysLeft >= 4 && daysLeft <= 6) return `🕒 返事期限まであと${daysLeft}日`;
  if (daysLeft >= 1 && daysLeft <= 3) return `⚠️ 返事期限まであと${daysLeft}日`;
  if (daysLeft <= 0) return '❌ 期限切れ';
  return null;
};

const getConsentStatusClass = (status: number) => {
  switch (status) {
    case 1:
      return 'bg-red-100 text-red-800 border border-yellow-400';
    case 2:
      return 'bg-green-100 text-green-800 border border-green-400';
    case 3:
      return 'bg-gray-100 text-gray-800 border border-gray-400';
    default:
      return 'bg-gray-100 text-gray-700';
  }
};

export default function TeamInvitations({ myTeam, myTeamInvites, asGuestInvites, inviteStatuses }: Props) {
  const markAsRead = (id: string) => {
    router.post(route('myteam.markAsRead', id));
  };

  const renderInviteCard = (invite: InviteData) => {
    const deadlineLabel =
      invite.consent_status === 1
        ? getDeadlineLabel(invite.first_preferered_date, invite.second_preferered_date, invite.third_preferered_date)
        : null;

    return (
      <li
        key={invite.id}
        className="bg-blue-50 shadow-lg rounded-lg flex flex-col min-h-[420px] p-6"
      >
        <div className="flex-1 flex flex-col justify-between">
          <div>
            <div className="flex justify-between items-center mb-2">
              <div className="text-xl font-bold">{invite.team.name}</div>
              <span className={`text-xs font-bold px-2 py-1 rounded ${getConsentStatusClass(invite.consent_status)}`}>
                {inviteStatuses[invite.consent_status]}
              </span>
            </div>

            {invite.team.image && (
              <img
                src={invite.team.image.path_base64}
                alt="チーム画像"
                className="w-full h-40 object-cover rounded-lg mb-4"
              />
            )}

            <h3 className="text-md font-semibold">希望日程</h3>
            <ul className="text-gray-600 space-y-1">
              {renderDate('①', invite.first_preferered_date, invite.game_date ?? undefined)}
              {invite.second_preferered_date && renderDate('②', invite.second_preferered_date, invite.game_date ?? undefined)}
              {invite.third_preferered_date && renderDate('③', invite.third_preferered_date, invite.game_date ?? undefined)}
            </ul>
          </div>
        </div>

        <div className="mt-4 flex flex-wrap gap-2">
          <Link
            href={route('myteam.consent_game.detail', invite.id)}
            className="text-indigo-500 hover:underline"
          >
            招待の詳細をみる
          </Link>
          {deadlineLabel && (
            <span className="text-sm text-red-500 font-medium">{deadlineLabel}</span>
          )}
        </div>
      </li>
    );
  };

  return (
    <AuthenticatedLayout>
      <Head title="チーム招待状況" />

      <div className="max-w-4xl mx-auto py-8 px-4">
        {!myTeam ? (
          <div className="bg-white shadow-md rounded-lg p-6 text-center">
            <h2 className="text-xl font-semibold">チームに所属していません</h2>
            <p className="text-gray-500">まずはチームを登録するか、招待を受け取って参加しましょう。</p>
            <div className="mt-4">
              <Link
                href={route('new_team.index')}
                className="bg-green-500 text-white px-4 py-2 rounded-md shadow hover:bg-green-600"
              >
                チームを登録する
              </Link>
            </div>
          </div>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <h2 className="text-lg font-semibold border-b pb-2 text-blue-700">あなたが招待したチーム</h2>
              <ul className="mt-4 space-y-4">
                {myTeamInvites.length > 0 ? myTeamInvites.map(renderInviteCard) : (
                  <p className="text-gray-500">まだ招待したチームはありません。</p>
                )}
              </ul>
            </div>
            <div>
              <h2 className="text-lg font-semibold border-b pb-2 text-green-700">あなたを招待したチーム</h2>
              <ul className="mt-4 space-y-4">
                {asGuestInvites.length > 0 ? asGuestInvites.map(renderInviteCard) : (
                  <p className="text-gray-500">まだ招待されているチームはありません。</p>
                )}
              </ul>
            </div>
          </div>
        )}
      </div>
    </AuthenticatedLayout>
  );
}

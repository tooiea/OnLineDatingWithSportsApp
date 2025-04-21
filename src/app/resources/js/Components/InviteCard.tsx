import React from 'react';
import { Link } from '@inertiajs/react';
import dayjs from 'dayjs';
import 'dayjs/locale/ja';
import ConsentStatusClass from './ConsentStatusClass';
import getFormattedFullDateTime from './FormattedFullDateTime';

dayjs.locale('ja');

export interface InviteData {
  id: string;
  created_at: string;
  consent_status: number;
  first_preferered_date: string;
  second_preferered_date?: string;
  third_preferered_date?: string;
  unread?: boolean;
  team: {
    id: string;
    name: string;
    image?: {
      path_base64: string;
    };
  };
  game_date?: string | null;
}

export interface InviteCardProps {
  invite: InviteData;
  inviteStatuses: Record<number, string>;
  isInviter?: boolean;
}

const renderDate = (label: string, date?: string, highlightDate?: string) => {
  const isPast = date ? dayjs(date).isBefore(dayjs()) : false;
  const isHighlight = highlightDate && date && dayjs(date).isSame(highlightDate, 'day');
  const faded = highlightDate && date && !dayjs(date).isSame(highlightDate, 'day');

  return (
    <li className="flex items-center gap-2">
      <span className="font-semibold">{label}</span>
      <span
        className={`${
          isPast ? 'line-through text-gray-400' : ''
        } ${faded ? 'text-gray-400' : ''} ${isHighlight ? 'font-bold text-blue-700' : ''}`.trim()}
      >
        {getFormattedFullDateTime(date)}
      </span>
    </li>
  );
};

const getDeadlineLabel = (
  first?: string,
  second?: string,
  third?: string
): string | null => {
  const dates = [first, second, third]
    .filter((d): d is string => !!d)
    .map((d) => dayjs(d))
    .sort((a, b) => b.valueOf() - a.valueOf());

  if (dates.length === 0) return null;

  const deadline = dates[0].subtract(7, 'day');
  const daysLeft = deadline.diff(dayjs(), 'day');

  if (daysLeft === 7) return `⏰ 返事期限まであと7日`;
  if (daysLeft >= 4 && daysLeft <= 6) return `🕒 返事期限まであと${daysLeft}日`;
  if (daysLeft >= 1 && daysLeft <= 3) return `⚠️ 返事期限まであと${daysLeft}日`;
  if (daysLeft <= 0) return '❌ 期限切れ';
  return null;
};

const InviteCard: React.FC<InviteCardProps> = ({ invite, inviteStatuses, isInviter }) => {
  const deadlineLabel =
    invite.consent_status === 0
      ? getDeadlineLabel(
          invite.first_preferered_date,
          invite.second_preferered_date,
          invite.third_preferered_date
        )
      : null;

  const detailRoute = isInviter
    ? route('myteam.consent_game.detail', invite.id)
    : invite.consent_status === 0
    ? route('myteam.consent_game.reply.index', invite.id)
    : route('myteam.consent_game.detail', invite.id);

  return (
    <li className="relative bg-blue-50 shadow rounded-xl w-[350px] flex flex-col min-h-[400px] p-6">
      <div className="flex-1 flex flex-col justify-between">
        <div>
          <div className="flex justify-between items-center mb-2">
            <div className="text-lg font-bold truncate max-w-[250px]">{invite.team.name}</div>
            <span className={`text-xs font-bold px-2 py-1 rounded ${ConsentStatusClass(invite.consent_status)}`}>
              {inviteStatuses[invite.consent_status]}
            </span>
          </div>

          <div className="relative mb-3">
            {invite.team.image && (
              <>
                <img
                  src={invite.team.image.path_base64}
                  alt="チーム画像"
                  className="w-full aspect-square object-cover rounded-xl"
                />
                {invite.unread && (
                  <div
                    className="absolute top-0 left-0 w-full bg-yellow-500 text-white text-center text-sm font-bold py-2 rounded-t-xl z-10 shadow-md transition-opacity duration-500 animate-fade-in"
                  >
                    🔔 新着返信があります
                  </div>
                )}
              </>
            )}
          </div>

          <h3 className="text-md font-semibold">希望日程</h3>
          <ul className="text-gray-600 space-y-1">
            {renderDate('①', invite.first_preferered_date, invite.game_date ?? undefined)}
            {invite.second_preferered_date &&
              renderDate('②', invite.second_preferered_date, invite.game_date ?? undefined)}
            {invite.third_preferered_date &&
              renderDate('③', invite.third_preferered_date, invite.game_date ?? undefined)}
          </ul>
        </div>
      </div>

      <div className="mt-4 flex flex-wrap gap-2">
        <Link
          href={detailRoute}
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

export default InviteCard;

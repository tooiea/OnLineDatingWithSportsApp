interface Props {
    className?: string;
}

export default function ApplicationLogo({ className }: Props) {
    return (
        <img
            src='/images/logo.png'
            alt="OLDWS ロゴ"
            className={className || 'h-12 w-12'}
        />
    );
}

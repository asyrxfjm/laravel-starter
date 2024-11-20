export interface Role {
    name: string;
}

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    roles?: Role[];
}

export interface Permission {
    name: string;
}

export interface Permissions {
    [key: string]: Permission[];
}

export interface Course {
    id: string;
    name: string;
    duration: number;
    description: string;
    code: string;
    matric_type: string;
    matric_number_prefix: string;
    fee_type: string;
    course_fee: number;
    registration_fee: number;
    loan_applicable: string[];
    is_short_course: boolean;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
};

export type Link = {
    url: string;
    label: string;
    active: boolean;
};

export type PaginateMeta<T> = {
    current_page: number;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: Link[];
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
    data: T[];
};
